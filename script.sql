CREATE TABLE IF NOT EXISTS historico_temperatura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    temperatura FLOAT NOT NULL,
    horario_registro DATETIME NOT NULL
);