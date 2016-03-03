CREATE TABLE `temp_humid` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `sensor_id` int(11) NOT NULL,
 `date` datetime NOT NULL,
 `temperature` int(11) NOT NULL,
 `humidity` int(11) NOT NULL,
 UNIQUE KEY `id_2` (`id`),
 KEY `id` (`id`),
 KEY `datetime` (`date`,`sensor_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8