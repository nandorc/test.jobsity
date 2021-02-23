--
-- Table users
--
drop table if exists users;
create table users(
    uid varchar(50) not null comment 'User Identifier',
    pwd varchar(255) not null comment 'Password',
    currency varchar(5) not null comment 'Currency type',
    balance int unsigned not null default 0 comment 'Account balance',
    created_at datetime not null default current_timestamp comment 'DateTime for creation',
    updated_at datetime not null default current_timestamp comment 'DateTime for update',
    primary key(uid) comment 'Setting uid as PK'
) comment 'Table for users';

--
-- Table transaction_logs
--
drop table if exists transaction_logs;
create table transaction_logs(
    id int unsigned not null auto_increment comment 'Unique id for transaction',
    type enum('deposit','withdraw') not null comment 'Type of transaction',
    currency varchar(5) not null comment 'Currency type for amount',
    amount int unsigned not null comment 'Amount of transaction',
    status enum('A','R') not null comment 'Transaction status. (A) Accepted (R) Rejected',
    details varchar(255) not null comment 'Additional details on transaction, (ex. rejected reason)',
    created_at datetime not null default current_timestamp comment 'Datetime for creation',
    updated_at datetime not null default current_timestamp comment 'Datetime for update',
    account varchar(50) not null comment 'Reference to account owner',
    primary key(id) comment 'Setting id as PK',
    index i_account(account) comment 'Set account as index for FK'
) comment 'Table for transaction logs';
alter table transaction_logs add foreign key(account) references users(uid)
    on update cascade on delete cascade;
