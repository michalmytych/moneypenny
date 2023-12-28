# create test database
CREATE DATABASE IF NOT EXISTS `moneypenny-test`;

# grant rights
GRANT ALL PRIVILEGES ON `moneypenny-test`.* TO 'moneypenny-test'@'%';
