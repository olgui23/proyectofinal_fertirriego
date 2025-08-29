# Host: localhost:33065  (Version 5.5.5-10.4.32-MariaDB)
# Date: 2025-05-27 11:17:11
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "usuarios"
#

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

#
# Data for table "usuarios"
#

INSERT INTO `usuarios` VALUES (1,'Juan Pérez','juan@correo.com','admin'),(2,'Maria López','maria@correo.com','tecnico'),(3,'Carlos Ramos','carlos@correo.com','agricultor'),(4,'Luis Flores','luis@correo.com','agricultor'),(5,'Ana Rojas','ana@correo.com','admin');
