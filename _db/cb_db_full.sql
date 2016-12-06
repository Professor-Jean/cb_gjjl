-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 27-Nov-2016 às 00:09
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cb_db`
--
CREATE DATABASE IF NOT EXISTS `cb_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cb_db`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `canceled_events`
--

CREATE TABLE `canceled_events` (
  `id` smallint(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar os indentificadores únicos dos eventos cancelados.',
  `clients_id` smallint(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de clientes em eventos cancelados.',
  `locals_id` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de locais em eventos cancelados.',
  `event_date` date NOT NULL COMMENT 'Campo destinado a armazenar a data que o evento seria realizado.',
  `local` tinyint(1) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o tipo de local no qual seria realizado o evento cancelado.\nTipos: Locais da Empresa\n           Local do Cliente\n           Outro Locais\n',
  `reason` char(2) NOT NULL COMMENT 'Campo destinado a armazenar o motivo do cancelamento do evento.',
  `repaymant` decimal(6,2) UNSIGNED DEFAULT NULL COMMENT 'Campo destinado a armazenar o valor do ressarcimento pago ao cliente pelo cancelamento do evento.',
  `forfeit` decimal(6,2) UNSIGNED DEFAULT NULL COMMENT 'Campo destinado a armazenar o valor da multa paga pelo cliente pelo cancelamento do evento.',
  `comment` varchar(255) DEFAULT NULL COMMENT 'Campo destinado a armazenar os comentários relacionados ao cancelamento do evento.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os eventos cancelados.';

--
-- Extraindo dados da tabela `canceled_events`
--

INSERT INTO `canceled_events` (`id`, `clients_id`, `locals_id`, `event_date`, `local`, `reason`, `repaymant`, `forfeit`, `comment`) VALUES
(00001, 00001, 03, '2016-11-29', 0, 'FI', NULL, NULL, 'Estou desempregado.'),
(00002, 00004, 01, '2016-11-30', 0, 'IN', NULL, NULL, NULL),
(00003, 00004, 03, '2016-12-03', 0, 'AF', NULL, NULL, NULL),
(00004, 00003, NULL, '2016-12-01', 1, 'FI', NULL, NULL, NULL),
(00005, 00002, NULL, '2016-12-01', 1, 'FI', NULL, NULL, NULL),
(00006, 00002, 01, '2016-11-28', 0, 'AF', NULL, NULL, NULL),
(00007, 00002, NULL, '2016-12-01', 1, 'OT', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cities`
--

CREATE TABLE `cities` (
  `id` tinyint(1) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar os indentificadores únicos da cidade',
  `name` varchar(30) NOT NULL COMMENT 'Campo destinado a armazenar os nomes das cidades.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar as cidades.';

--
-- Extraindo dados da tabela `cities`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(1, 'Joinville'),
(2, 'Florianópolis');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clients`
--

CREATE TABLE `clients` (
  `id` smallint(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar os indentificadores únicos dos clientes.',
  `districts_id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de bairros em clientes.',
  `name` varchar(45) NOT NULL COMMENT 'Campo destinado a armazenar os nomes dos clientes.',
  `email` varchar(70) NOT NULL COMMENT 'Campo destinado a armazenar os e-mails dos clientes.',
  `phone` bigint(15) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar os telefones dos clientes.',
  `birthdate` date NOT NULL COMMENT 'Campo destinado a armazenar as datas de nascimento dos clientes.',
  `rg` varchar(10) NOT NULL COMMENT 'Campo destinado a armazenar o RG dos clientes.',
  `cpf` bigint(11) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o CPF dos clientes.',
  `cep` int(8) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o CEP do endereço dos clientes.',
  `street` varchar(40) NOT NULL COMMENT 'Campo destinado a armazenar o Logradouro do endereço dos clientes.',
  `number` smallint(5) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o Número da casa dos clientes.',
  `complement` varchar(20) DEFAULT NULL COMMENT 'Campo destinado a armazenar o Complemento do endereço dos clientes.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os clientes.';

--
-- Extraindo dados da tabela `clients`
--

INSERT INTO `clients` (`id`, `districts_id`, `name`, `email`, `phone`, `birthdate`, `rg`, `cpf`, `cep`, `street`, `number`, `complement`) VALUES
(00001, 05, 'João Pedro da Silva', 'joao.silva@gmail.com', 4734256325, '1993-03-12', '4546468754', 78975646132, 89556321, 'Rua José rosa', 152, 'casa'),
(00002, 01, 'Gabriel da Silva', 'gabriel.silva@gmail.com', 4734256325, '1999-08-03', '9879845461', 45646132131, 89679562, 'Rua Pedro dos Passos', 156, 'casa'),
(00003, 03, 'JoãoGonçalves', 'joao@gmail.com', 4734562135, '1990-11-22', '8541968415', 78676546213, 89556321, 'Rua Arco Íris', 1532, 'casa'),
(00004, 04, 'Lucas da Silva', 'l.silva@gmail.com', 4734563215, '1997-07-17', '2752372782', 78967867656, 89665231, 'Rua Cignus', 145, 'casa'),
(00005, 05, 'João Vitor', 'joao.vitor@gmail.com', 4734267856, '1998-11-04', '2458965653', 34345345453, 89556326, 'Avenida das Nações', 152, 'casa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `delivery_route`
--

CREATE TABLE `delivery_route` (
  `users_id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de usuários em rotas de entrega.',
  `events_id` smallint(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de eventos na rotade entrega.',
  `order_number` tinyint(2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar a ordem dos eventos a serem entregues nas rotas de entrega.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar as rotas de entrega.';

--
-- Extraindo dados da tabela `delivery_route`
--

INSERT INTO `delivery_route` (`users_id`, `events_id`, `order_number`) VALUES
(005, 00008, 4),
(005, 00012, 1),
(005, 00026, 3),
(005, 00027, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `districts`
--

CREATE TABLE `districts` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar os indeficadores únicos de bairro.',
  `cities_id` tinyint(1) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de cidades em bairros.',
  `name` varchar(25) NOT NULL COMMENT 'Campo destinado a armazenar os nomes dos bairros.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os bairros.';

--
-- Extraindo dados da tabela `districts`
--

INSERT INTO `districts` (`id`, `cities_id`, `name`) VALUES
(01, 1, 'Aventureiro'),
(02, 1, 'Costa e silva'),
(03, 1, 'Iririú'),
(04, 1, 'Paraíso'),
(05, 2, 'Canasvieiras'),
(06, 2, 'Barra da Lagoa'),
(07, 2, 'Trindade');

-- --------------------------------------------------------

--
-- Estrutura da tabela `employees`
--

CREATE TABLE `employees` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar o indentificador único de cada colaborador.',
  `users_id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de usuários em colaboradores.',
  `name` varchar(45) NOT NULL COMMENT 'Campo destinado a armazenar os nomes dos colaboradores.',
  `email` varchar(70) NOT NULL COMMENT 'Campo destinado a armazenar os e-mails dos colaboradores.',
  `phone` bigint(15) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar os telefones dos colaboradores.',
  `birthdate` date NOT NULL COMMENT 'Campo destinado a armazenar as datas de nascimento dos colaboradores.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os colaboradores.';

--
-- Extraindo dados da tabela `employees`
--

INSERT INTO `employees` (`id`, `users_id`, `name`, `email`, `phone`, `birthdate`) VALUES
(001, 006, 'João Santucci', 'jpfsantucci@gmail.com', 4734256323, '1999-02-18'),
(002, 007, 'João Spieker', 'joao.spieker@gmail.com', 4734156536, '1999-02-21'),
(003, 008, 'Gabriel Dezan', 'gabriel20053@gmail.com', 4734562369, '2000-06-24'),
(004, 009, 'Lucas Janning', 'lucasjanning1@gmail.com', 4734256323, '1998-11-19'),
(005, 010, 'Colab', 'colab@gmail.com', 4734256323, '1992-07-16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `events`
--

CREATE TABLE `events` (
  `id` smallint(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar os indentificadores únicos dos eventos.',
  `clients_id` smallint(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de clientes em eventos.',
  `districts_id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de bairros em eventos.',
  `locals_id` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de locais em eventos.',
  `local` tinyint(1) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o tipo de local em que será realizado o evento.\nPossibilidades: Locais da Empresa\n                        Local do Cliente\n                        Outros Locais \n',
  `cep` int(8) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar os CEPs dos locais nos quais serão realizados os eventos. Caso seja escolhido um local da empresa ou local do cliente, o campo é preenchido automaticamente, caso seja escolhido outros locais é necessário preencher este campo.',
  `street` varchar(40) NOT NULL COMMENT 'Campo destinado a armazenar os logradouros dos locais nos quais serão realizados os eventos. Caso seja escolhido um local da empresa ou local do cliente, o campo é preenchido automaticamente, caso seja escolhido outros locais é necessário preencher este campo.',
  `number` smallint(5) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar os números dos locais nos quais serão realizados os eventos. Caso seja escolhido um local da empresa ou local do cliente, o campo é preenchido automaticamente, caso seja escolhido outros locais é necessário preencher este campo.',
  `event_date` date NOT NULL COMMENT 'Campo destinado a armazenar as datas de realização dos eventos.',
  `event_time` time NOT NULL COMMENT 'Campo destinado a armazenar os horários de realização dos eventos.',
  `discount` decimal(5,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o desconto que será dado em cima do valor atual do evento.',
  `entry_fee` decimal(5,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar a taxa de entrada do pagamento do evento.',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o status do evento.\nTipos:0 - Pendente\n          1 - Confirmado\n          2 - Realizado',
  `rent_value` decimal(6,2) UNSIGNED DEFAULT NULL COMMENT 'Campo destinado a armazenar o valor de aluguel para o local do evento.',
  `delivery_fee` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Campo destinado a armazenar a taxa de entrega do evento.',
  `complement` varchar(20) DEFAULT NULL COMMENT 'Campo destinado a armazenar o complemento do local no qual será realizado o evento. Caso seja escolhido um local da empresa ou local do cliente, o campo é preenchido automaticamente, caso seja escolhido outros locais é necessário preencher este campo.',
  `observation` varchar(255) DEFAULT NULL COMMENT 'Campo destinado a armazenar uma observação sobre o evento.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os eventos.';

--
-- Extraindo dados da tabela `events`
--

INSERT INTO `events` (`id`, `clients_id`, `districts_id`, `locals_id`, `local`, `cep`, `street`, `number`, `event_date`, `event_time`, `discount`, `entry_fee`, `status`, `rent_value`, `delivery_fee`, `complement`, `observation`) VALUES
(00001, 00001, 05, NULL, 1, 89556321, 'Rua José rosa', 152, '2016-11-28', '15:00:00', '10.00', '18.00', 1, NULL, '5.00', 'casa', NULL),
(00003, 00003, 02, 02, 0, 89665213, 'Rua Pavão', 4562, '2016-11-28', '13:00:00', '5.00', '12.00', 1, '132.00', '18.00', 'casa', NULL),
(00004, 00002, 04, 03, 0, 89665321, 'Rua Cignus', 563, '2016-11-28', '13:00:00', '10.00', '17.00', 1, '253.00', '0.00', 'casa', NULL),
(00006, 00002, 01, NULL, 1, 89679562, 'Rua Pedro dos Passos', 156, '2016-11-29', '15:00:00', '3.00', '15.00', 1, NULL, '12.00', 'casa', NULL),
(00007, 00004, 01, 01, 0, 89556231, 'Tuiuti', 123, '2016-11-29', '20:00:00', '5.00', '5.00', 1, '230.00', '10.00', 'casa', NULL),
(00008, 00004, 04, NULL, 1, 89665231, 'Rua Cignus', 145, '2016-11-27', '15:00:00', '10.00', '10.00', 1, NULL, '5.00', 'casa', NULL),
(00012, 00003, 04, 03, 0, 89665321, 'Rua Cignus', 563, '2016-11-27', '18:00:00', '6.00', '32.00', 1, '253.00', '16.00', 'casa', NULL),
(00013, 00002, 01, NULL, 1, 89679562, 'Rua Pedro dos Passos', 156, '2016-12-02', '15:00:00', '5.00', '8.00', 1, NULL, '0.00', 'casa', NULL),
(00014, 00003, 03, NULL, 1, 89556321, 'Rua Arco Íris', 1532, '2016-12-25', '15:00:00', '5.00', '6.00', 1, NULL, '13.00', 'casa', NULL),
(00015, 00004, 04, 03, 0, 89665321, 'Rua Cignus', 563, '2016-12-25', '12:00:00', '5.00', '7.00', 1, '253.00', '20.00', 'casa', NULL),
(00017, 00001, 05, NULL, 1, 89556321, 'Rua José rosa', 152, '2016-12-02', '14:00:00', '6.00', '14.00', 1, NULL, '12.00', 'casa', NULL),
(00018, 00003, 04, 03, 0, 89665321, 'Rua Cignus', 563, '2017-01-01', '14:00:00', '6.00', '21.00', 1, '253.00', '12.00', 'casa', NULL),
(00019, 00003, 03, NULL, 1, 89556321, 'Rua Arco Íris', 1532, '2017-01-05', '12:00:00', '5.00', '3.00', 1, NULL, '10.00', 'casa', NULL),
(00020, 00003, 03, NULL, 1, 89556321, 'Rua Arco Íris', 1532, '2016-11-28', '10:00:00', '5.00', '5.00', 1, NULL, '10.00', 'casa', NULL),
(00021, 00002, 02, 02, 0, 89665213, 'Rua Pavão', 4562, '2016-11-29', '10:00:00', '7.00', '8.00', 1, '132.00', '17.00', 'casa', NULL),
(00022, 00004, 04, NULL, 1, 89665231, 'Rua Cignus', 145, '2016-11-29', '12:00:00', '5.00', '4.00', 1, NULL, '12.00', 'casa', NULL),
(00023, 00002, 04, 03, 0, 89665321, 'Rua Cignus', 563, '2016-10-01', '12:00:00', '5.00', '15.00', 2, '253.00', '8.00', 'casa', NULL),
(00025, 00001, 02, 02, 0, 89665213, 'Rua Pavão', 4562, '2016-10-01', '15:00:00', '3.00', '17.00', 2, '132.00', '14.00', 'casa', NULL),
(00026, 00003, 03, NULL, 1, 89556321, 'Rua Arco Íris', 1532, '2016-11-27', '16:00:00', '0.00', '10.00', 1, NULL, '0.00', 'casa', NULL),
(00027, 00005, 05, NULL, 1, 89556326, 'Avenida das Nações', 152, '2016-11-27', '12:00:00', '5.00', '5.00', 1, NULL, '12.00', 'casa', NULL),
(00028, 00005, 04, 03, 0, 89665321, 'Rua Cignus', 563, '2016-09-30', '22:00:00', '0.00', '10.00', 2, '253.00', '10.00', 'casa', NULL),
(00029, 00005, 02, 02, 0, 89665213, 'Rua Pavão', 4562, '2016-09-02', '20:00:00', '10.00', '13.00', 2, '132.00', '15.00', 'casa', NULL),
(00030, 00005, 02, 02, 0, 89665213, 'Rua Pavão', 4562, '2016-08-26', '15:00:00', '4.00', '12.00', 2, '132.00', '12.00', 'casa', NULL),
(00031, 00004, 01, 01, 0, 89556231, 'Tuiuti', 123, '2016-08-26', '18:30:00', '0.00', '20.00', 2, '230.00', '10.00', 'casa', NULL),
(00032, 00003, 03, NULL, 1, 89556321, 'Rua Arco Íris', 1532, '2016-07-26', '22:00:00', '5.00', '10.00', 2, NULL, '15.00', 'casa', NULL),
(00033, 00002, 01, 01, 0, 89556231, 'Tuiuti', 123, '2016-11-30', '12:00:00', '10.00', '0.00', 0, '230.00', '14.00', 'casa', NULL),
(00034, 00003, 02, 02, 0, 89665213, 'Rua Pavão', 4562, '2016-11-30', '14:00:00', '0.00', '0.00', 0, '132.00', '12.00', 'casa', NULL),
(00035, 00001, 05, NULL, 1, 89556321, 'Rua José rosa', 152, '2016-12-01', '15:00:00', '5.00', '0.00', 0, NULL, '12.00', 'casa', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `events_has_items`
--

CREATE TABLE `events_has_items` (
  `events_id` smallint(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de eventos na entidade associativa.',
  `items_id` smallint(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de itens na entidade associativa.',
  `item_quantity` tinyint(2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar a quantidade de itens em cada evento.',
  `actual_value` decimal(6,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o valor atual dos itens dentro do evento.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os itens presentes em cada evento.';

--
-- Extraindo dados da tabela `events_has_items`
--

INSERT INTO `events_has_items` (`events_id`, `items_id`, `item_quantity`, `actual_value`) VALUES
(00004, 0015, 4, '35.00'),
(00007, 0005, 2, '26.00'),
(00007, 0017, 1, '20.00'),
(00018, 0016, 1, '14.00'),
(00018, 0017, 2, '20.00'),
(00020, 0005, 2, '26.00'),
(00020, 0007, 1, '56.00'),
(00022, 0017, 12, '20.00'),
(00025, 0017, 12, '20.00'),
(00032, 0014, 5, '16.00'),
(00032, 0017, 4, '20.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `events_has_kits`
--

CREATE TABLE `events_has_kits` (
  `events_id` smallint(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de eventos na entidade associativa.',
  `kits_id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de kits na entidade associativa.',
  `kit_quantity` tinyint(2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar a quantidade de kits no evento.',
  `actual_value` decimal(6,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o valor atual de todos os kits dentro do eventos.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `events_has_kits`
--

INSERT INTO `events_has_kits` (`events_id`, `kits_id`, `kit_quantity`, `actual_value`) VALUES
(00001, 008, 1, '250.00'),
(00003, 012, 1, '481.00'),
(00004, 011, 2, '77.00'),
(00006, 009, 1, '377.00'),
(00007, 011, 2, '77.00'),
(00008, 011, 1, '77.00'),
(00008, 013, 2, '322.00'),
(00012, 008, 1, '250.00'),
(00012, 009, 1, '377.00'),
(00013, 010, 1, '113.00'),
(00013, 011, 1, '77.00'),
(00014, 010, 2, '113.00'),
(00014, 012, 1, '481.00'),
(00015, 009, 1, '377.00'),
(00017, 013, 1, '322.00'),
(00018, 010, 2, '113.00'),
(00019, 010, 1, '113.00'),
(00019, 012, 1, '481.00'),
(00020, 009, 1, '377.00'),
(00021, 011, 1, '77.00'),
(00022, 010, 2, '113.00'),
(00022, 011, 1, '77.00'),
(00023, 009, 1, '377.00'),
(00023, 013, 2, '322.00'),
(00025, 011, 1, '77.00'),
(00026, 010, 2, '113.00'),
(00026, 011, 1, '77.00'),
(00027, 011, 2, '77.00'),
(00028, 014, 3, '139.00'),
(00029, 010, 1, '113.00'),
(00029, 014, 2, '139.00'),
(00030, 011, 3, '77.00'),
(00031, 010, 1, '113.00'),
(00032, 010, 1, '113.00'),
(00033, 008, 1, '250.00'),
(00033, 010, 1, '113.00'),
(00034, 009, 1, '377.00'),
(00035, 010, 1, '113.00'),
(00035, 011, 1, '77.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `expenses`
--

CREATE TABLE `expenses` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar o indentificador único de despesas.',
  `expenses_types_id` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  `date` date NOT NULL COMMENT 'Campo destinado a armazenar a data de despesa.',
  `value` decimal(7,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o valor da despesa.',
  `description` varchar(255) DEFAULT NULL COMMENT 'Campo destinado a armazenar a descrição da despesa.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar as despesas.';

--
-- Extraindo dados da tabela `expenses`
--

INSERT INTO `expenses` (`id`, `expenses_types_id`, `date`, `value`, `description`) VALUES
(001, 01, '2016-11-09', '120.00', NULL),
(002, 02, '2016-11-08', '132.00', NULL),
(003, 01, '2016-10-13', '150.00', NULL),
(004, 02, '2016-10-09', '123.00', NULL),
(005, 03, '2016-11-11', '57.00', NULL),
(006, 03, '2016-10-12', '65.00', NULL),
(007, 01, '2016-09-14', '150.00', NULL),
(008, 03, '2016-09-13', '54.00', NULL),
(009, 02, '2016-09-05', '130.00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `expenses_types`
--

CREATE TABLE `expenses_types` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar os indentificadores únicos dos tipos de despesas.',
  `name` varchar(25) NOT NULL COMMENT 'Campo destinado a armazenar os nomes das despesas.',
  `comment` varchar(255) DEFAULT NULL COMMENT 'Campo destinado a armazenar os comentários relacionados aos tipos de despesas.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os tipos de despesas.';

--
-- Extraindo dados da tabela `expenses_types`
--

INSERT INTO `expenses_types` (`id`, `name`, `comment`) VALUES
(01, 'Conta Água', 'Tipo de Despesa para contas de água. '),
(02, 'Conta Luz', 'Tipo de Despesa para contas de luz.'),
(03, 'Conta Gás', '	Tipo de Despesa para contas de gás.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `items`
--

CREATE TABLE `items` (
  `id` smallint(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar os indentificadores únicos dos itens',
  `name` varchar(40) NOT NULL COMMENT 'Campo destinado a armazenar os nomes dos itens.',
  `quantity` tinyint(3) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar a quantidade existente de cada item.',
  `value` decimal(6,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o valor unitário de cada item.',
  `description` varchar(255) DEFAULT NULL COMMENT 'Campo destinado a armazenar as descrições dos itens.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os itens.';

--
-- Extraindo dados da tabela `items`
--

INSERT INTO `items` (`id`, `name`, `quantity`, `value`, `description`) VALUES
(0001, 'Porta Bolo Azul', 10, '12.00', 'Porta bolo azul para festas.'),
(0002, 'Porta Bolo Verde', 15, '12.00', 'Porta bolo Verde para festas.'),
(0003, 'Cortina Verde', 5, '14.00', 'Cortina Verde para festas.'),
(0004, 'Cortina Azul', 23, '15.00', 'Cortina Azul para festas.'),
(0005, 'Vaso Verde', 3, '26.00', 'Vaso Verde para festas.'),
(0006, 'Mesa Azul', 2, '32.00', 'Mesa Azul para festas.\r\n\r\nTam: 75x75x50cm'),
(0007, 'Mesa Verde', 1, '56.00', 'Mesa Verde para festas.\r\n\r\nTam: 120x80x50cm'),
(0008, 'Toalha Mesa Azul', 3, '13.00', 'Toalha de mesa Azul para festas.'),
(0009, 'Cama elástica', 2, '123.00', 'Cama elástica para festas.'),
(0010, 'Piscina de Bolinhas', 3, '87.00', 'Piscina de bolinhas para festas.'),
(0011, 'Vaso Azul', 10, '22.00', 'Vaso azul para festas.'),
(0012, 'Toalha Mesa Verde', 15, '15.00', 'Toalha mesa Verde para festas.'),
(0013, 'Porta Bolo Natal', 12, '15.00', 'Porta bolo de natal para festas.'),
(0014, 'Cortina de Natal', 5, '16.00', 'Cortina de natal para festas.'),
(0015, 'Mesa natal', 13, '35.00', 'Mesa de natal para festas.'),
(0016, 'Toalha Mesa Natal', 2, '14.00', 'Toalha para mesa de natal para festas.'),
(0017, 'Vaso Natal', 16, '20.00', 'Vaso de natal para festas.	');

-- --------------------------------------------------------

--
-- Estrutura da tabela `kits`
--

CREATE TABLE `kits` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar os indentificadores únicos dos kits.',
  `name` varchar(20) NOT NULL COMMENT 'Campo destinado a armazenar os nomes dos kits.',
  `discount` decimal(5,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o desconto em cima do valor atual do kit.',
  `description` varchar(255) DEFAULT NULL COMMENT 'Campo destinado a armazenar as descrições dos kits.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os Kits.';

--
-- Extraindo dados da tabela `kits`
--

INSERT INTO `kits` (`id`, `name`, `discount`, `description`) VALUES
(008, 'Kit Verde', '10.00', NULL),
(009, 'Kit Azul', '10.00', NULL),
(010, 'Kit Cama elástica', '10.00', NULL),
(011, 'Kit PiscinaBolinnhas', '10.00', NULL),
(012, 'Kit Natal', '10.00', NULL),
(013, 'Kit Mix', '10.00', NULL),
(014, 'Kit Mix 2', '10.00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `kits_has_items`
--

CREATE TABLE `kits_has_items` (
  `kits_id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de Kits na entidade associativa.',
  `items_id` smallint(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de itens na entidade associativa.',
  `item_quantity` tinyint(2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar a quntidade de itens em cada Kit.',
  `actual_value` decimal(6,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar o valor atual do kit.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os itens presentes em cada kit.';

--
-- Extraindo dados da tabela `kits_has_items`
--

INSERT INTO `kits_has_items` (`kits_id`, `items_id`, `item_quantity`, `actual_value`) VALUES
(008, 0002, 3, '12.00'),
(008, 0003, 4, '14.00'),
(008, 0005, 2, '26.00'),
(008, 0007, 1, '56.00'),
(008, 0012, 4, '15.00'),
(009, 0001, 5, '12.00'),
(009, 0004, 7, '15.00'),
(009, 0006, 2, '32.00'),
(009, 0008, 2, '13.00'),
(009, 0011, 6, '22.00'),
(010, 0009, 1, '123.00'),
(011, 0010, 1, '87.00'),
(012, 0013, 5, '15.00'),
(012, 0014, 3, '16.00'),
(012, 0015, 4, '35.00'),
(012, 0016, 2, '14.00'),
(012, 0017, 10, '20.00'),
(013, 0001, 2, '12.00'),
(013, 0003, 2, '14.00'),
(013, 0009, 1, '123.00'),
(013, 0010, 1, '87.00'),
(013, 0015, 2, '35.00'),
(014, 0004, 1, '15.00'),
(014, 0011, 2, '22.00'),
(014, 0015, 2, '35.00'),
(014, 0017, 1, '20.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `locals`
--

CREATE TABLE `locals` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar o indentificar único dos locais.',
  `districts_id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar a chave estrangeira de bairros em locais.',
  `name` varchar(30) NOT NULL COMMENT 'Campo destinado a armazenar os nomes dos locais.',
  `area` decimal(7,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar as áreas dos locais(m²).',
  `height` decimal(4,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar as alturas dos locais(m).',
  `cep` int(8) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar os CEPs dos locais.',
  `street` varchar(40) NOT NULL COMMENT 'Campo destinado a armazenar os logradouros dos locais.',
  `number` smallint(5) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar os números dos locais.',
  `rent_value` decimal(6,2) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar os valores para aluguel dos locais.',
  `description` varchar(255) DEFAULT NULL COMMENT 'Campo destinado a armazenar as descrições dos locais.',
  `complement` varchar(20) DEFAULT NULL COMMENT 'Campo destinado a armazenar os complementos dos locais.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar os locais pertencentes a empresa destinados a eventos.';

--
-- Extraindo dados da tabela `locals`
--

INSERT INTO `locals` (`id`, `districts_id`, `name`, `area`, `height`, `cep`, `street`, `number`, `rent_value`, `description`, `complement`) VALUES
(01, 01, 'Cris Blau 1', '120.00', '3.00', 89556231, 'Tuiuti', 123, '230.00', 'Local para festas 1.', 'casa'),
(02, 02, 'Cris Blau 2', '53.00', '2.50', 89665213, 'Rua Pavão', 4562, '132.00', 'Local para festas 2.', 'casa'),
(03, 04, 'Cris Blau 3', '53.00', '3.50', 89665321, 'Rua Cignus', 563, '253.00', 'Local para festas 3.', 'casa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Campo destinado a armazenar o indentificador único de cada usuário.',
  `username` varchar(20) NOT NULL COMMENT 'Campo destinado a armazenar os nomes de usuário.',
  `password` char(32) NOT NULL COMMENT 'Campo destinado a armazenar as senhas dos usuários, que serão criptografadas em MD5. ',
  `permission` tinyint(1) UNSIGNED NOT NULL COMMENT 'Campo destinado a armazenar as permissões dos usuários. \nValores: 0 - Administrador\n              1 - Colaborador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela destinada a armazenar todos os usuários.';

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `permission`) VALUES
(001, 'Santucci', 'ec1cfd66d8a28404cc0ede0a51a30d83', 0),
(002, 'Spieker', 'ec1cfd66d8a28404cc0ede0a51a30d83', 0),
(003, 'Dezan', 'c20fa88f87969fe237164690f8b5619e', 0),
(004, 'Janning', 'ec1cfd66d8a28404cc0ede0a51a30d83', 0),
(005, 'adm', 'ec1cfd66d8a28404cc0ede0a51a30d83', 0),
(006, 'SantucciColab', 'ec1cfd66d8a28404cc0ede0a51a30d83', 1),
(007, 'SpiekerColab', 'ec1cfd66d8a28404cc0ede0a51a30d83', 1),
(008, 'DezanColab', 'ec1cfd66d8a28404cc0ede0a51a30d83', 1),
(009, 'JanningColab', 'ec1cfd66d8a28404cc0ede0a51a30d83', 1),
(010, 'Colab', 'ec1cfd66d8a28404cc0ede0a51a30d83', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `canceled_events`
--
ALTER TABLE `canceled_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_canceled_events_locals1_idx` (`locals_id`),
  ADD KEY `fk_canceled_events_clients1_idx` (`clients_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_clients_districts1_idx` (`districts_id`);

--
-- Indexes for table `delivery_route`
--
ALTER TABLE `delivery_route`
  ADD PRIMARY KEY (`users_id`,`events_id`),
  ADD KEY `fk_delivery_route_events1_idx` (`events_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_districts_cities1_idx` (`cities_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employees_users1_idx` (`users_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_clients1_idx` (`clients_id`),
  ADD KEY `fk_events_locals1_idx` (`locals_id`),
  ADD KEY `fk_events_districts1_idx` (`districts_id`);

--
-- Indexes for table `events_has_items`
--
ALTER TABLE `events_has_items`
  ADD PRIMARY KEY (`events_id`,`items_id`),
  ADD KEY `fk_events_has_items_items1_idx` (`items_id`),
  ADD KEY `fk_events_has_items_events1_idx` (`events_id`);

--
-- Indexes for table `events_has_kits`
--
ALTER TABLE `events_has_kits`
  ADD PRIMARY KEY (`events_id`,`kits_id`),
  ADD KEY `fk_events_has_kits_kits1_idx` (`kits_id`),
  ADD KEY `fk_events_has_kits_events1_idx` (`events_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_expenses_expenses_types1_idx` (`expenses_types_id`);

--
-- Indexes for table `expenses_types`
--
ALTER TABLE `expenses_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kits`
--
ALTER TABLE `kits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kits_has_items`
--
ALTER TABLE `kits_has_items`
  ADD PRIMARY KEY (`kits_id`,`items_id`),
  ADD KEY `fk_kits_has_items_items1_idx` (`items_id`),
  ADD KEY `fk_kits_has_items_kits_idx` (`kits_id`);

--
-- Indexes for table `locals`
--
ALTER TABLE `locals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_locals_districts1_idx` (`districts_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `canceled_events`
--
ALTER TABLE `canceled_events`
  MODIFY `id` smallint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar os indentificadores únicos dos eventos cancelados.', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar os indentificadores únicos da cidade', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` smallint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar os indentificadores únicos dos clientes.', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar os indeficadores únicos de bairro.', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar o indentificador único de cada colaborador.', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` smallint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar os indentificadores únicos dos eventos.', AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar o indentificador único de despesas.', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `expenses_types`
--
ALTER TABLE `expenses_types`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar os indentificadores únicos dos tipos de despesas.', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` smallint(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar os indentificadores únicos dos itens', AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `kits`
--
ALTER TABLE `kits`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar os indentificadores únicos dos kits.', AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `locals`
--
ALTER TABLE `locals`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar o indentificar único dos locais.', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Campo destinado a armazenar o indentificador único de cada usuário.', AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `canceled_events`
--
ALTER TABLE `canceled_events`
  ADD CONSTRAINT `fk_canceled_events_clients1` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_canceled_events_locals1` FOREIGN KEY (`locals_id`) REFERENCES `locals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_clients_districts1` FOREIGN KEY (`districts_id`) REFERENCES `districts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `delivery_route`
--
ALTER TABLE `delivery_route`
  ADD CONSTRAINT `fk_delivery_route_events1` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_delivery_route_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `fk_districts_cities1` FOREIGN KEY (`cities_id`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_clients1` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_events_districts1` FOREIGN KEY (`districts_id`) REFERENCES `districts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_events_locals1` FOREIGN KEY (`locals_id`) REFERENCES `locals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `events_has_items`
--
ALTER TABLE `events_has_items`
  ADD CONSTRAINT `fk_events_has_items_events1` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_events_has_items_items1` FOREIGN KEY (`items_id`) REFERENCES `items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `events_has_kits`
--
ALTER TABLE `events_has_kits`
  ADD CONSTRAINT `fk_events_has_kits_events1` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_events_has_kits_kits1` FOREIGN KEY (`kits_id`) REFERENCES `kits` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_expenses_expenses_types1` FOREIGN KEY (`expenses_types_id`) REFERENCES `expenses_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `kits_has_items`
--
ALTER TABLE `kits_has_items`
  ADD CONSTRAINT `fk_kits_has_items_items1` FOREIGN KEY (`items_id`) REFERENCES `items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_kits_has_items_kits` FOREIGN KEY (`kits_id`) REFERENCES `kits` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `locals`
--
ALTER TABLE `locals`
  ADD CONSTRAINT `fk_locals_districts1` FOREIGN KEY (`districts_id`) REFERENCES `districts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
