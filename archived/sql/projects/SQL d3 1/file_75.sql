CREATE TABLE `shop`.`d3_products`
(
  `id`        INT          NOT NULL AUTO_INCREMENT,
  `developer` VARCHAR(256) NOT NULL,
  `unix_time` INT          NOT NULL,
  `name`      VARCHAR(256) NOT NULL,
  `price`     INT          NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;
CREATE TABLE `shop`.`d3_suppliers`
(
  `id`       INT          NOT NULL,
  `name`     VARCHAR(256) NOT NULL,
  `address`  VARCHAR(256) NOT NULL,
  `phone`    VARCHAR(256) NOT NULL,
  `director` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;
CREATE TABLE `shop`.`d3_deliveries`
(
  `id`           INT          NOT NULL,
  `name`         VARCHAR(256) NOT NULL,
  `unix_time`    INT          NOT NULL,
  `delivered_by` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;
CREATE TABLE `shop`.`d3_employees`
(
  `id`            INT          NOT NULL,
  `fio`           VARCHAR(256) NOT NULL,
  `unix_time`     INT          NOT NULL,
  `type`          INT          NOT NULL,
  `years_of_work` INT          NOT NULL,
  `savings`       INT          NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;
CREATE TABLE `shop`.`d3_sales`
(
  `id`         INT NOT NULL,
  `unix_time`  INT NOT NULL,
  `quantiny`   INT NOT NULL,
  `product_id` INT NOT NULL,
  `price`      INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;
CREATE TABLE `shop`.`d3_buyers`
(
  `id`      INT          NOT NULL,
  `fio`     VARCHAR(256) NOT NULL,
  `off`     INT          NOT NULL,
  `address` VARCHAR(256) NOT NULL,
  `phone`   VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;