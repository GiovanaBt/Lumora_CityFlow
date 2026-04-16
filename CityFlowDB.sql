CREATE DATABASE IF NOT EXISTS CityFlow;
USE CityFlow;

-- 1. TABELA DE USUÁRIOS
CREATE TABLE IF NOT EXISTS Usuarios (
    id_usuarios INT PRIMARY KEY AUTO_INCREMENT,
    nome_completo VARCHAR(100),
    data_nascimento DATE,
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(100),
    nome_usuario VARCHAR(100)
);

-- 2. TABELA DE CATEGORIAS
-- Deve ser criada antes de 'Eventos_Cadastrados' para a Chave Estrangeira funcionar.
CREATE TABLE IF NOT EXISTS Categoria (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    categoria_evento VARCHAR(100)
);

-- 3. TABELA DE EVENTOS (ESTRUTURA CORRETA)
CREATE TABLE IF NOT EXISTS Eventos_Cadastrados (
    id_evento INT PRIMARY KEY AUTO_INCREMENT,
    id_usuarios INT NOT NULL,
    
    -- Campos Separados:
    titulo VARCHAR(255) NOT NULL,    -- O Nome/Título do evento
    descricao TEXT,                  -- Descrição longa e detalhada
    
    -- Localização:
    rua VARCHAR(100),
    bairro VARCHAR(100),
    numero INT,
    cidade VARCHAR(100),
    ponto_referencia VARCHAR(255),   -- Apenas o ponto de referência puro
    
    -- Datas e Horários:
    data_inicio_evento DATE,
    data_fim_evento DATE,
    horario_inicio_evento TIME,
    horario_fim_evento TIME,
    
    -- Outros:
    id_categoria INT NOT NULL, 
    Imagem VARCHAR(255),             -- Nome do arquivo da imagem salva
    evento_concluido VARCHAR(35) DEFAULT 'Pendente',
    
    -- Relacionamentos:
    FOREIGN KEY (id_usuarios) REFERENCES Usuarios(id_usuarios) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria) ON DELETE CASCADE
);

-- 4. TABELA DE ATIVIDADE / FEEDBACK
CREATE TABLE IF NOT EXISTS Atividade (
    id_atividade INT PRIMARY KEY AUTO_INCREMENT,
    id_usuarios INT NOT NULL,
    id_evento INT NOT NULL,
    id_categoria INT NOT NULL, 
    feedback TEXT,
    FOREIGN KEY (id_usuarios) REFERENCES Usuarios(id_usuarios) ON DELETE CASCADE,
    FOREIGN KEY (id_evento) REFERENCES Eventos_Cadastrados(id_evento) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria) ON DELETE CASCADE
);

-- 5. INSERÇÃO DE CATEGORIAS PADRÃO
INSERT INTO Categoria (categoria_evento) VALUES
('Música'), ('Dança'), ('Leitura'), ('Gastronomia'), ('Esporte'), 
('Cinema'), ('Teatro'), ('Performance'), ('Pintura/Arte'), 
('Educação'),('Standups'), ('Congressos/Paletras'),('Cursos/Workshops'),('Pride'),
('Religião/Espiritualidade'),('Recitar'), ('Escrita/poemas');