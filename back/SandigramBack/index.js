var Client = require('instagram-private-api').V1;
var device;
var storage; 


var mysql = require('mysql');
var moment = require("moment");

var SandiGram = {
    user: '',
    pass: '',
    init: function () {
        console.log("inicializo Pool");
        this.dbPool = mysql.createPool({
            connectionLimit: 10,
            host: 'localhost',
            user: 'root',
            password: '',
            database: 'sandigram'
        });

        var minutes = 3, the_interval = minutes * 60 * 1000;

        setInterval(function () {
            console.log("Loop");
            SandiGram.getPosts();
        }, the_interval);

    },
    dbPool: '',
    updatePostStatus: function (idPost, status) {
        console.log("actualizo el estado del post");

        var sql = "UPDATE publicaciones SET id_estado = " + status + "  WHERE id = " + idPost + ";";
        this.dbPool.getConnection(function (err, connection) {
            if (!err) {
                connection.query(sql, function (error, results, fields) {
                    if (typeof results !== 'undefined' && results.affectedRows) {
                        console.log("QUERY OK!")
                    } else {
                        console.log("QUERY FAIL!");
                        console.log(error.message)
                    }
                    connection.release();
                });
            }
        });
    },
    uploadPhoto: function (idPost, imagePath, caption, user, password) {

        Client.Session.create(device, storage, user, password)
                .then(function (session) {
                    console.log("session engaged");
                    console.log("uploading photo..");
                    Client.Upload.photo(session, imagePath)
                            .then(function (upload) {
                                console.log("uploaded");
                                console.log(upload.params.uploadId);
                                console.log("configure photo");
                                Client.Media.configurePhoto(session, upload.params.uploadId, caption)
                                        .then(function () {
                                            console.log("photo configured OK");
                                            //actualizo el estado del post a publicado
                                            SandiGram.updatePostStatus(idPost, 2);
                                        }, function (error) {
                                            console.log("photo configured FAILed");
                                            //error
                                            console.log(error.message)
                                            SandiGram.updatePostStatus(idPost, 3);
                                            SandiGram.logError(idPost, false, "Error al configurar la imagen -- " + error.message);

                                        });


                            }, function (error) {
                                //error al uplodear
                                console.log("upload error");
                                console.log(error);
                                SandiGram.updatePostStatus(idPost, 3);
                                SandiGram.logError(idPost, false, "Error al subir la imagen --" + error.message)

                            })
                            .then(function (medium) {
                                if (typeof medium !== 'undefined') {
                                    console.log(medium.params);
                                }

                            });

                });
    },
    logError: function (idPost, isGeneralError, errorMsg) {

        console.log("error log");
        var id_post = !!idPost ? parseInt(idPost) : 0;
        var error_general = !!isGeneralError ? 1 : 0;
        var texto_error = this.dbPool.escape(errorMsg);
        var sql = "INSERT INTO errores  (id_publicacion, error_general, texto_error) VALUES  (" + id_post + " , " + error_general + " ," + texto_error + ");";
        this.dbPool.getConnection(function (err, connection) {
            if (!err) {
                connection.query(sql, function (error, results, fields) {
                    if (typeof results !== 'undefined' && results.affectedRows) {
                        console.log("QUERY OK!");
                    } else {
                        console.log("QUERY FAIL!");
                        console.log(error.message);
                    }
                    connection.release();
                });
            }
        });
    },
    getPosts: function () {
        console.log("traigo posts");
        var sql = "SELECT p.id, id_estado, p.nombre, texto, fecha_publicacion, nombre_archivo, ruta_completa,user,password FROM sandigram.publicaciones p LEFT JOIN medios m ON m.id = p.id_medio LEFT JOIN cuentas c on p.id_cuenta = c.id WHERE p.id_estado = 1 AND p.id_cuenta != 14;";

        this.dbPool.getConnection(function (err, connection) {
            if (err) {
                throw err;
            }
            connection.query(sql, function (error, results, fields) {
                if (!error) {
                    for (var i = 0; i < results.length; i++) {
                        var publicacion = results[i];
                        if (publicacion.id_estado === 1) {
                            //el post no fue publicado

                            var fechaPost = moment(publicacion.fecha_publicacion);
                            var ahora = new Date();

                            var minutosDiff = fechaPost.diff(ahora, "minutes");
                            console.log("fecha", fechaPost)
                            console.log("minutos", minutosDiff)

                            if (minutosDiff > -10 && minutosDiff <= 10) {
                                console.log("lo publico");
                                var textoPubli = new Buffer(publicacion.texto, 'base64').toString();
                                
                                device = new Client.Device(publicacion.user);
                                storage = new Client.CookieFileStorage(__dirname + '/cookies/'+publicacion.user+'.json');
                                SandiGram.uploadPhoto(publicacion.id, publicacion.ruta_completa, textoPubli, publicacion.user, publicacion.password);
                            } else {
                                console.log("no lo publico");
                            }
                        }
                    }
                } else {
                    console.log(error);
                }

                connection.release();
            });
        });

    }
};

SandiGram.init();



 