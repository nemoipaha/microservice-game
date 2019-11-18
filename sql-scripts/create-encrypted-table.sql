create table `test_encryption` (
	`id` int(10) unsigned not null auto_increment,
    `text` varchar(255) not null,
    primary key (`id`)
) engine=InnoDB encrypted=YES encryption_key_id = 1;