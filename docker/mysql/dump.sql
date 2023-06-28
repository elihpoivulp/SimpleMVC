create table if not exists messages
(
    id      int          not null primary key auto_increment,
    message varchar(100) not null
);

insert into messages (message)
values ('hello, world!');