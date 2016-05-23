-- MySQL Script generated by MySQL Workbench
-- Mon May 23 04:12:48 2016
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema coneypark
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `admin_recurso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `admin_recurso` ;

CREATE TABLE IF NOT EXISTS `admin_recurso` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `recurso_id` INT(11) NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `url` VARCHAR(120) NULL DEFAULT NULL,
  `orden` INT NOT NULL,
  `icono` VARCHAR(50) NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  `estado` SMALLINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_admin_recurso_admin_recurso1_idx` (`recurso_id` ASC),
  CONSTRAINT `fk_admin_recurso_admin_recurso1`
    FOREIGN KEY (`recurso_id`)
    REFERENCES `admin_recurso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `admin_rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `admin_rol` ;

CREATE TABLE IF NOT EXISTS `admin_rol` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  `estado` SMALLINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `admin_permiso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `admin_permiso` ;

CREATE TABLE IF NOT EXISTS `admin_permiso` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `acl` VARCHAR(5) NULL DEFAULT NULL,
  `rol_id` INT(11) NOT NULL,
  `recurso_id` INT(11) NOT NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_admin_permiso_admin_rol1_idx` (`rol_id` ASC),
  INDEX `fk_admin_permiso_admin_recurso1_idx` (`recurso_id` ASC),
  CONSTRAINT `fk_admin_permiso_admin_rol1`
    FOREIGN KEY (`rol_id`)
    REFERENCES `admin_rol` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_admin_permiso_admin_recurso1`
    FOREIGN KEY (`recurso_id`)
    REFERENCES `admin_recurso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `admin_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `admin_usuario` ;

CREATE TABLE IF NOT EXISTS `admin_usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `rol_id` INT(11) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `estado` TINYINT(1) NOT NULL DEFAULT 0,
  `codigo_activar` VARCHAR(100) NULL,
  `imagen` VARCHAR(50) NULL DEFAULT NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_admin_usuario_admin_rol1_idx` (`rol_id` ASC),
  CONSTRAINT `fk_admin_usuario_admin_rol1`
    FOREIGN KEY (`rol_id`)
    REFERENCES `admin_rol` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `usuario_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuario_usuario` ;

CREATE TABLE IF NOT EXISTS `usuario_usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `mguid` VARCHAR(40) NOT NULL,
  `facebook_id` VARCHAR(30) NULL,
  `twitter_id` VARCHAR(30) NULL,
  `email` VARCHAR(30) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `estado` TINYINT(1) NOT NULL,
  `imagen` VARCHAR(50) NULL,
  `nombres` VARCHAR(30) NOT NULL,
  `paterno` VARCHAR(30) NOT NULL,
  `materno` VARCHAR(30) NULL,
  `di_tipo` INT NULL,
  `di_valor` VARCHAR(11) NULL,
  `fecha_nac` DATE NULL,
  `pais_id` INT NULL,
  `departamento_id` INT NULL,
  `provincia_id` INT NULL,
  `distrito_id` INT NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  `codigo_activar` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  INDEX `index_facebook_id` (`facebook_id` ASC),
  INDEX `index_twitter_id` (`twitter_id` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `mguid_UNIQUE` (`mguid` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `tarjeta_tarjeta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tarjeta_tarjeta` ;

CREATE  TABLE IF NOT EXISTS `tarjeta_tarjeta` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `usuario_id` INT NOT NULL ,
  `nombre` VARCHAR(150) NULL ,
  `cguid` VARCHAR(40) NOT NULL ,
  `numero` VARCHAR(12) NOT NULL ,
  `emoney` FLOAT NULL ,
  `emoneyvalue` FLOAT NULL ,
  `bonus` FLOAT NULL ,
  `bonusvalue` FLOAT NULL ,
  `promotionbonus` FLOAT NULL ,
  `bonusplusvalue` FLOAT NULL ,
  `gamepoints` FLOAT NULL ,
  `gamepointsvalue` FLOAT NULL ,
  `etickets` FLOAT NULL ,
  `estado_truefi` TINYINT(1) NULL ,
  `fecha_creacion` DATETIME NULL ,
  `fecha_edicion` DATETIME NULL ,
  `fecha_actualizacion` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_tarjeta_tarjeta_usuario_usuario1_idx` (`usuario_id` ASC) ,
  UNIQUE INDEX `cguid_UNIQUE` (`cguid` ASC) ,
  INDEX `index_numero` (`numero` ASC) ,
  INDEX `index_fecha_actualizacion` (`fecha_actualizacion` ASC) ,
  CONSTRAINT `fk_tarjeta_tarjeta_usuario_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `usuario_usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `paquete_paquete`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paquete_paquete` ;

CREATE TABLE IF NOT EXISTS `paquete_paquete` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `referencia` VARCHAR(32) NOT NULL,
  `titulo1` VARCHAR(200) NULL,
  `titulo2` VARCHAR(200) NULL,
  `tipo` INT NOT NULL,
  `imagen` VARCHAR(120) NULL,
  `emoney` FLOAT NULL,
  `bonus` FLOAT NOT NULL,
  `promotionbonus` FLOAT NULL,
  `etickets` FLOAT NULL,
  `gamepoints` FLOAT NOT NULL,
  `legal` TEXT NULL,
  `activo` TINYINT(1) NULL DEFAULT 0,
  `destacado` TINYINT(1) NULL DEFAULT 0,
  `orden` INT NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `referencia_index` (`referencia` ASC),
  INDEX `tipo_index` (`tipo` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orden_orden`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orden_orden` ;

CREATE TABLE IF NOT EXISTS `orden_orden` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(120) NULL COMMENT 'Código de la orden, también llamado Código de Transacción',
  `usuario_id` INT NOT NULL,
  `comprobante_tipo` TINYINT(1) NOT NULL COMMENT '1:BOLETA, 2:FACTURA',
  `fac_razon_social` VARCHAR(150) NULL,
  `documento_tipo` INT NULL COMMENT '1:RUC, 2:DNI',
  `documento_numero` VARCHAR(11) NULL,
  `fac_direccion_fiscal` VARCHAR(150) NULL,
  `fac_direccion_entrega_factura` VARCHAR(150) NULL,
  `nombres` VARCHAR(30) NULL,
  `paterno` VARCHAR(30) NULL,
  `materno` VARCHAR(30) NULL,
  `ciudadania` TINYINT(1) NULL,
  `direccion` VARCHAR(150) NULL,
  `pais_id` INT NULL,
  `distrito_id` INT NULL,
  `pago_referencia` VARCHAR(30) NULL,
  `pago_tarjeta` VARCHAR(5) NULL,
  `pago_metodo` VARCHAR(10) NULL COMMENT 'VISA, PE',
  `pago_estado` VARCHAR(12) NULL COMMENT 'PAGO, ERROR, PENDIENTE, EXPIRADO',
  `monto` FLOAT(10,2) NULL,
  `estado` INT(1) NULL COMMENT 'Estado de registro\nactivo, inactivo',
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  `pago_error` VARCHAR(120) NULL,
  `pago_error_detalle` TEXT NULL,
  `pago_fecha_confirmacion` DATETIME NULL,
  `pago_cip` VARCHAR(120) NULL,
  `pago_token` VARCHAR(150) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orden_orden_usuario_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_orden_orden_usuario_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuario_usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orden_detalle_orden`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orden_detalle_orden` ;

CREATE TABLE IF NOT EXISTS `orden_detalle_orden` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `paquete_id` INT NOT NULL,
  `orden_id` INT NOT NULL,
  `tarjeta_id` INT NOT NULL,
  `emoney` FLOAT NULL COMMENT 'Dinero',
  `bonus` FLOAT NULL COMMENT 'Coney Bonos',
  `promotionbonus` FLOAT NULL COMMENT 'Coney Bonos Plus',
  `etickets` FLOAT NULL COMMENT 'Tickets',
  `gamepoints` FLOAT NULL COMMENT 'Game Points',
  `monto` FLOAT(10,2) NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  `cantidad` INT(1) NULL DEFAULT 1,
  `recarga_cantidad` INT(1) NULL,
  `recarga_error` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orden_detalle_orden_paquete_paquete1_idx` (`paquete_id` ASC),
  INDEX `fk_orden_detalle_orden_orden_orden1_idx` (`orden_id` ASC),
  INDEX `fk_orden_detalle_orden_tarjeta_tarjeta1_idx` (`tarjeta_id` ASC),
  CONSTRAINT `fk_orden_detalle_orden_paquete_paquete1`
    FOREIGN KEY (`paquete_id`)
    REFERENCES `paquete_paquete` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orden_detalle_orden_orden_orden1`
    FOREIGN KEY (`orden_id`)
    REFERENCES `orden_orden` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orden_detalle_orden_tarjeta_tarjeta1`
    FOREIGN KEY (`tarjeta_id`)
    REFERENCES `tarjeta_tarjeta` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `usuario_perfil_pago`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuario_perfil_pago` ;

CREATE TABLE IF NOT EXISTS `usuario_perfil_pago` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `comprobante_tipo` TINYINT(1) NOT NULL,
  `comprobante_numero` VARCHAR(10) NULL,
  `fac_razon_social` VARCHAR(150) NULL,
  `fac_ruc` VARCHAR(11) NULL,
  `fac_direccion_fiscal` VARCHAR(150) NULL,
  `fac_direccion_entrega_factura` VARCHAR(150) NULL,
  `nombres` VARCHAR(30) NULL,
  `paterno` VARCHAR(30) NULL,
  `materno` VARCHAR(30) NULL,
  `ciudadania` TINYINT(1) NULL,
  `documento_tipo` INT NULL,
  `documento_numero` VARCHAR(11) NULL,
  `direccion` VARCHAR(150) NULL,
  `pais_id` INT NULL,
  `distrito_id` INT NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_perfil_pago_usuario_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_perfil_pago_usuario_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuario_usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sistema_ubigeo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sistema_ubigeo` ;

CREATE TABLE IF NOT EXISTS `sistema_ubigeo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cod_pais` VARCHAR(2) NOT NULL,
  `cod_depa` VARCHAR(2) NOT NULL,
  `cod_prov` VARCHAR(2) NOT NULL,
  `cod_dist` VARCHAR(2) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `index_pais` (`cod_pais` ASC),
  INDEX `index_depa` (`cod_depa` ASC),
  INDEX `index_prov` (`cod_prov` ASC),
  INDEX `index_dist` (`cod_dist` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orden_request_historial`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orden_request_historial` ;

CREATE TABLE IF NOT EXISTS `orden_request_historial` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `orden_id` INT NOT NULL,
  `request` TEXT NULL,
  `response` TEXT NULL,
  `estado` SMALLINT(1) NOT NULL DEFAULT 1 COMMENT '1:activo, 0:inactivo',
  `tarjeta` VARCHAR(5) NULL,
  `pago_referencia` VARCHAR(30) NULL,
  `fecha_creacion` DATETIME NOT NULL,
  `fecha_edicion` DATETIME NULL,
  `method` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orden_carrito`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orden_carrito` ;

CREATE TABLE IF NOT EXISTS `orden_carrito` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `pago_referencia` VARCHAR(30) NULL,
  `pago_estado` VARCHAR(1) NULL,
  `pago_tarjeta` VARCHAR(5) NULL,
  `monto` FLOAT NULL,
  `estado` TINYINT(1) NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orden_carrito_usuario_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_orden_carrito_usuario_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuario_usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orden_detalle_carrito`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orden_detalle_carrito` ;

CREATE TABLE IF NOT EXISTS `orden_detalle_carrito` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `paquete_id` INT NOT NULL,
  `carrito_id` INT NOT NULL,
  `tarjeta_id` INT NOT NULL,
  `emoney` FLOAT NULL,
  `bonus` FLOAT NULL,
  `promotionbonus` FLOAT NULL,
  `etickets` FLOAT NULL,
  `gamepoints` FLOAT NULL,
  `monto` FLOAT NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orden_detalle_carrito_paquete_paquete1_idx` (`paquete_id` ASC),
  INDEX `fk_orden_detalle_carrito_orden_carrito1_idx` (`carrito_id` ASC),
  INDEX `fk_orden_detalle_carrito_tarjeta_tarjeta1_idx` (`tarjeta_id` ASC),
  CONSTRAINT `fk_orden_detalle_carrito_paquete_paquete1`
    FOREIGN KEY (`paquete_id`)
    REFERENCES `paquete_paquete` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orden_detalle_carrito_orden_carrito1`
    FOREIGN KEY (`carrito_id`)
    REFERENCES `orden_carrito` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orden_detalle_carrito_tarjeta_tarjeta1`
    FOREIGN KEY (`tarjeta_id`)
    REFERENCES `tarjeta_tarjeta` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cms_contenido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cms_contenido` ;

CREATE TABLE IF NOT EXISTS `cms_contenido` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(60) NOT NULL,
  `tipo` INT NOT NULL,
  `titulo` VARCHAR(200) NULL,
  `url` VARCHAR(150) NULL,
  `contenido` TEXT NOT NULL,
  `estado` TINYINT(1) NULL DEFAULT 1,
  `fecha_creacion` DATETIME NULL,
  `fecha_edicion` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
