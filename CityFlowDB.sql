create database CityFlow;
use CityFlow;

create table Usuarios (
id_usuarios int primary key auto_increment,
nome_completo varchar(100),
data_nascimento date,
email varchar(100),
senha varchar(100),
nome_usuario varchar(100)
);
select * from Usuarios;

create table Eventos_Cadastrados (
id_evento int primary key auto_increment,
id_usuarios int not null,
descricao varchar(100),
rua varchar(100),
bairro varchar(100),
numero int,
cidade varchar(100),
ponto_referencia text,
data_evento date,
horario_evento time, 
id_categoria int not null, 
evento_concluido varchar(35),
FOREIGN KEY (id_usuarios) REFERENCES Usuarios(id_usuarios) ON DELETE CASCADE,
FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria) ON DELETE CASCADE
);
select * from Eventos_Cadastrados;	


create table Categoria (
id_categoria int primary key auto_increment,
categoria_evento varchar(100)
);
select * from Categoria;

insert into Categoria (categoria_evento) values
('Música'),
('Dança'),
('Leitura'),
('Gastronomia'),
('Esporte'),
('Cinema'),
('Teatro'),
('Performance'),
('Pintura/Arte'),
('Educação');

insert into Categoria (categoria_evento) values
('Recitar'),
('Escrita/poemas');


create table Atividade (
id_atividade int primary key auto_increment,
id_usuarios int not null,
id_evento int not null,
id_categoria int not null, 
feedback text,
FOREIGN KEY (id_usuarios) REFERENCES Usuarios(id_usuarios) ON DELETE CASCADE,
FOREIGN KEY (id_evento) REFERENCES Eventos_Cadastrados(id_evento) ON DELETE CASCADE,
FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria) ON DELETE CASCADE
);
select * from Atividade;

SELECT 
    Usuarios.nome_completo, 
    Eventos_Cadastrados.descricao AS Nome_Evento,
    Eventos_Cadastrados.rua,
    Eventos_Cadastrados.bairro,
    Eventos_Cadastrados.horario_evento
FROM Usuarios
INNER JOIN Eventos_Cadastrados 
    ON Usuarios.id_usuarios = Eventos_Cadastrados.id_usuarios;
    