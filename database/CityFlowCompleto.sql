CREATE DATABASE IF NOT EXISTS cityflow;
USE cityflow;

-- =========================
-- TABELA USUÁRIOS
-- =========================
CREATE TABLE usuarios (
    id_usuarios INT NOT NULL AUTO_INCREMENT,
    nome_completo VARCHAR(100),
    data_nascimento DATE,
    cpf VARCHAR(11),
    telefone VARCHAR(11),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(100),
    nome_usuario VARCHAR(100),
    PRIMARY KEY (id_usuarios)
);

-- =========================
-- TABELA CATEGORIA
-- =========================
CREATE TABLE categoria (
    id_categoria INT NOT NULL AUTO_INCREMENT,
    categoria_evento VARCHAR(100),
    PRIMARY KEY (id_categoria)
);

INSERT INTO categoria (categoria_evento) VALUES
('Música'),
('Dança'),
('Leitura'),
('Gastronomia'),
('Esporte'),
('Cinema'),
('Teatro'),
('Performance'),
('Pintura/Arte'),
('Educação'),
('Standups'),
('Congressos/Paletras'),
('Cursos/Workshops'),
('Pride'),
('Religião/Espiritualidade'),
('Recitar'),
('Escrita/poemas');

-- =========================
-- TABELA EVENTOS (SEM DATA FIXA)
-- =========================
CREATE TABLE eventos_cadastrados (
    id_evento INT NOT NULL AUTO_INCREMENT,
    id_usuarios INT NOT NULL,
    id_categoria INT NOT NULL,

    titulo VARCHAR(255) NOT NULL,
    subtitulo VARCHAR(255),
    descricao TEXT,

    descIMG VARCHAR(255),
    Imagem VARCHAR(255),

    rua VARCHAR(100),
    bairro VARCHAR(100),
    numero INT,
    cidade VARCHAR(100),
    CEP VARCHAR(11),
    ponto_referencia VARCHAR(255),

    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),

    PRIMARY KEY (id_evento),

    FOREIGN KEY (id_usuarios)
        REFERENCES usuarios(id_usuarios)
        ON DELETE CASCADE,

    FOREIGN KEY (id_categoria)
        REFERENCES categoria(id_categoria)
        ON DELETE CASCADE
);

-- =========================
-- TABELA DE DATAS DO EVENTO (CORRETO PARA EVENTOS MÚLTIPLOS DIAS)
-- =========================
CREATE TABLE datas_evento (
    id_data INT NOT NULL AUTO_INCREMENT,
    id_evento INT NOT NULL,

    data_inicio DATE NOT NULL,
    data_fim DATE DEFAULT NULL,

    horario_inicio TIME NOT NULL,
    horario_fim TIME NOT NULL,

    PRIMARY KEY (id_data),

    FOREIGN KEY (id_evento)
        REFERENCES eventos_cadastrados(id_evento)
        ON DELETE CASCADE
);

-- =========================
-- FAVORITOS
-- =========================
CREATE TABLE favoritos (
    id_favorito INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_evento INT NOT NULL,
    data_favorito TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id_favorito),

    FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuarios)
        ON DELETE CASCADE,

    FOREIGN KEY (id_evento)
        REFERENCES eventos_cadastrados(id_evento)
        ON DELETE CASCADE
);

-- =========================
-- ATIVIDADE
-- =========================
CREATE TABLE atividade (
    id_atividade INT NOT NULL AUTO_INCREMENT,
    id_usuarios INT NOT NULL,
    id_evento INT NOT NULL,
    id_categoria INT NOT NULL,
    feedback TEXT,

    PRIMARY KEY (id_atividade),

    FOREIGN KEY (id_usuarios)
        REFERENCES usuarios(id_usuarios)
        ON DELETE CASCADE,

    FOREIGN KEY (id_evento)
        REFERENCES eventos_cadastrados(id_evento)
        ON DELETE CASCADE,

    FOREIGN KEY (id_categoria)
        REFERENCES categoria(id_categoria)
        ON DELETE CASCADE
);
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE datas_evento;
TRUNCATE TABLE favoritos;
TRUNCATE TABLE atividade;
TRUNCATE TABLE eventos_cadastrados;

SET FOREIGN_KEY_CHECKS = 1;

select*from usuarios;

ALTER TABLE eventos_cadastrados
ADD classificacao_indicativa VARCHAR(20);

SELECT * FROM eventos_cadastrados;

