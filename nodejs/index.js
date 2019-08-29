const path = require('path');
const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const app = express();

const conn = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'oemoem' //Isi dengan nama DB yang sudah dibuatkan sebelumnya
});


// Melakukan koneksi ke db
conn.connect((err) => {
    if (err) throw err;
    console.log("db connected...");
});

var lists = [],
    dones = [];

function setList(result) {
    lists = result;
}

function setDone(result) {
    dones = result;
}

app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// Menampilkan todolist yang belum dan yang sudah dilakukan (Read)
app.get('/', (req, res) => {
    let sql_list = 'SELECT * FROM todolists WHERE status = false';
    conn.query(sql_list, (err, results) => {
        if (err) throw err;
        setList(results);

        let sql_done = 'SELECT * FROM todolists WHERE status = true';
        conn.query(sql_done, (err, results) => {
            if (err) throw err;
            setDone(results);

            res.render('index', {
                lists: lists,
                dones: dones
            });
        });
    });
});

// Memasukan todolist ke db (Create)
app.post('/', (req, res) => {
    let data = {
        todo: req.body.todo,
        status: false
    };
    let sql = "INSERT INTO todolists SET ?";

    conn.query(sql, data, (err, result) => {
        if (err) throw err;
        res.redirect('/');
    });
});

// Mengubah kondisi status menjadi true (Update)
app.post('/update', (req, res) => {
    let sql = "UPDATE todolists SET status = true WHERE id = " + req.body.update;
    console.log(sql);
    conn.query(sql, (err, result) => {
        if (err) throw err;
        res.redirect('/');
    });
});

// Menghapus kegiatan yang sudah dilakukan dari list (Delete)
app.post('/delete', (req, res) => {
    let sql = "DELETE FROM todolists WHERE id = " + req.body.delete;
    console.log(sql);
    conn.query(sql, (err, result) => {
        if (err) throw err;
        res.redirect('/');
    });
});

app.listen(8000, () => {
    console.log('server berjalan di port 8000');
});