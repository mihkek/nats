-- MySQL dump 10.14  Distrib 5.5.68-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: agro
-- ------------------------------------------------------
-- Server version	5.5.68-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auction_drug_list`
--

DROP TABLE IF EXISTS `auction_drug_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auction_drug_list` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) DEFAULT NULL,
  `active_material` varchar(1024) NOT NULL,
  `analogs` text,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`(255))
) ENGINE=InnoDB AUTO_INCREMENT=2010 DEFAULT CHARSET=utf8 COMMENT='Список препаратов с указанием действующего вещества';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auction_drug_list`
--

LOCK TABLES `auction_drug_list` WRITE;
/*!40000 ALTER TABLE `auction_drug_list` DISABLE KEYS */;
INSERT INTO `auction_drug_list` VALUES (1,'2,4-Дактив, КЭ','2,4-Д (сложный 2-этилгексиловый эфир) 564 г/л','Рапира, КЭ;Эндимион, КЭ',NULL),(2,'Абакус Прайм, СЭ','Пираклостробин + эпоксиконазол 85 + 62,5 г/л',NULL,'2022-10-17 09:53:57'),(3,'Абакус Ультра, СЭ','Пираклостробин + эпоксиконазол 62,5 + 62,5 г/л',NULL,'2022-10-17 09:53:57'),(4,'Абига-Пик, ВС','Хлорокись меди 400 г/л',NULL,'2022-10-17 09:53:57'),(5,'Абидос, ВР','Дикват (дибромид) 150 г/л диквата','Адекват, ВР;Альфа-Дикват, ВР;Волат, ВР;Голден Ринг, ВР;Десикант Экспертоф, ВР;Десикат Супер, ВР;Дикват, ВРК;Дикватерр Супер, ВР;Дикошанс, ВР;Донат, ВР;Лост, ВР;Молоток, ВР;Полис, ВР;Ранголи-Реголон, ВР;Регистан, ВРК;Реглон Форте, ВР;Результат Супер, ВР;Ректон, ВР;Суховей, ВР;Тонгара, ВР;Эквит, ВР','2022-10-17 09:53:57'),(6,'Абруста, КС','Пентиопирад + Ципроконазол 150 + 60 г/л',NULL,NULL),(7,'Аваксс, КЭ','Пропиконазол + Ципроконазол 250 + 80 г/л',NULL,NULL),(8,'Авангард, КЭ','С-Метолахлор 960 г/л','Анаконда, КЭ;Бегин, КЭ;Гуд-Харвест С-Метолахлор, КЭ;Джиндур, КЭ;Дифилайн, КЭ;Дуал Голд, КЭ','2022-10-17 09:53:57'),(9,'Авант, КЭ','Индоксакарб 150 г/л',NULL,'2022-10-17 09:53:57'),(10,'Авантикс 100, КЭ','Феноксапроп-П-этил + клоквинтосет-мексил 100 + 27 г/л','Акбарс, КЭ','2022-10-17 09:53:57'),(11,'Авантикс Турбо, МД','Феноксапроп-П-этил + антидот клоквинтосет-мексил +флукарбазон 100 + 34 + 17,5 г/л',NULL,NULL),(12,'Авантикс Экстра, ЭМВ','Феноксапроп-П-этил + антидот клоквинтосет-мексил 69 + 34,5 г/л','Ибис, ЭМВ;Ирбис, ЭМВ;Оцелот Плюс, КЭ;Тайгер, ЭМВ;Фабрис, ЭМВ;Феноксоп 7.5, ЭМВ;Фокстрот, ВЭ;Шансюген, ВЭ','2022-10-17 09:53:57'),(13,'Авиаль, КЭ','Тебуконазол + триадимефон 125 + 100 г/л','Фолиант, КЭ','2022-10-17 09:53:57'),(14,'Аврорекс, КЭ','2,4-Д (сложный 2-этилгексиловый эфир) + карфентразон-этил 332 г/л + 21 г/л',NULL,NULL),(15,'Агат-25 Супер, ТПС','3-индолилуксусная кислота + a-аланин + a-глутаминовая кислота 18 + 60 + 70 мг/кг',NULL,'2022-10-17 09:53:57'),(16,'Агент, ВДГ','Ацетамиприд 200 г/кг',NULL,'2022-10-17 09:53:57'),(17,'Агритокс, ВК','МЦПА (диметиламинная + калиевая + натриевая соли, смесь) 500 г/л МЦПА к-ты','Агрошанс, ВК;Аметил, ВРК;Гербитокс, ВРК;Линтаплант, ВК','2022-10-17 09:53:57'),(19,'Агроксон, ВР','МЦПА (диметиламинная соль) 750 г/л МЦПА к-ты','Дикопур М, ВР','2022-10-17 09:53:57'),(20,'Агро-Лайт, ВРК','Имазамокс + имазапир 33 + 15 г/л',NULL,NULL),(21,'Агролекарь, КЭ','Пропиконазол 250 г/л','Пеон, КЭ;Прогноз, КЭ;Профи, КЭ;Профикс, КЭ;Скиф, КЭ;Тилт, КЭ;Тимус, КЭ;Атлант, КЭ;Пропи Плюс, КЭ;ПропиШанс, КЭ;Титан, КЭ;Чистофлор, КЭ','2022-10-17 09:53:57'),(22,'Агрон Гранд, ВДГ','Клопиралид 750 г/кг','Клео, ВДГ;Клопер 750, ВДГ;Клопирид, ВДГ;Лонтерр, ВДГ;Лонтрел гранд, ВДГ;Монолит, ВДГ','2022-10-17 09:53:57'),(23,'Агрон, ВР','Клопиралид 300 г/л','Альфа-Пиралид, ВР;Бис-300, ВР;Газонтрел, ВР;Клорит, ВР;Корректор, ВР;Лонган, ВР;Лонтрел-300, ВР;Лорнет, ВР;Премьер 300, ВР;Хакер 300, ВР;Хатор, ВР;Цукрон+, ВР;Шанстрел 300, ВР','2022-10-17 09:53:57'),(24,'Агроника Гранд, МД','Мезотрион + Никосульфурон 70 + 40 г/л',NULL,'2022-10-17 09:53:57'),(25,'Агроника, КС','Никосульфурон 40 г/л',NULL,'2022-10-17 09:53:57'),(26,'Агростар Гранд, ВДГ','Трибенурон-метил + Флорасулам 630 + 120 г/кг',NULL,NULL),(27,'Агростар, ВДГ','Трибенурон-метил 750 г/кг','Альфа Стар, ВДГ;Аргамак, ВДГ;Аргамак, ВДГ-1001;Артстар, ВДГ;Бен Гур, ВДГ;Бенрил, ВДГ;Гекстар, ВДГ;Герсотил, ВДГ;Герсотил, ВДГ+;Гран-при, ВДГ;Гранат, ВДГ;Гранд Плюс, ВДГ;Гранилин, ВДГ;Гренадер, ВДГ;Громстор, ВДГ;Грэнери, ВДГ;Гюрза, СП;Коррида, ВДГ;Мортира, ВДГ;Норман, ВДГ;Прометей, ВДГ;Ранголи-Трибенурон, ВДГ;Санфло, ВДГ;Спецназ 750, ВДГ;Сталкер, ВДГ;Старбокс, СТС;Суперстар, ВДГ;Таллер, ВДГ;Террастар, ВДГ;ТриАлт, ВДГ;Трибел, ВДГ;Трибинстар, ВДГ;Трибун, СТС;Трибунал, ВДГ;Тризлак, ВДГ;Триметил, ВДГ;Триммер, ВДГ;Ферат, ВДГ;Флюенс, ВДГ;Химстар, ВДГ;Шанстар, ВДГ;Экспресс, ВДГ','2022-10-17 09:53:57'),(28,'АгроСтимул, ВЭ','Дигидрокверцетин 50 г/л',NULL,'2022-10-17 09:53:57'),(29,'Агростимулин, ВСР','2,6-диметилпиридин-N-оксид + продукты метаболизма симбионтного гриба Cylindrocarpon magnusianum 25+1 г/л',NULL,'2022-10-17 09:53:57'),(35,'Агрошанс, ВК','МЦПА (диметиламинная + калиевая + натриевая соли, смесь) 500 г/л МЦПА к-ты','Агритокс, ВК;Аметил, ВРК;Гербитокс, ВРК;Линтаплант, ВК','2022-10-17 09:53:57'),(36,'Адванс, ВДГ','Флутриафол 800 г/кг',NULL,'2022-10-17 09:53:57'),(37,'Адвокат, ВР','Дикамба (диметиламинная соль) 480 г/л','Альфа-Дикамба, ВРК;Витара, ВР;Герб-480, ВР;Губернатор, ВР;Дамба, ВР;Девиз, ВР;Деймос, ВРК;Декабрист, ВР;Диамант, ВР;Дианат, ВР;Диастар, ВР;Дикамбел, ВР;Ларт, ВР;Мономакс, ВР;Мурал, ВР;Оптимум, ВР;Санпэй, ВР;Шанс ДКБ, ВР;Банвел, ВР','2022-10-17 09:53:57'),(38,'Адекват, ВР','Дикват (дибромид) 150 г/л диквата','Абидос, ВР;Альфа-Дикват, ВР;Волат, ВР;Голден Ринг, ВР;Десикант Экспертоф, ВР;Десикат Супер, ВР;Дикват, ВРК;Дикватерр Супер, ВР;Дикошанс, ВР;Донат, ВР;Лост, ВР;Молоток, ВР;Полис, ВР;Ранголи-Реголон, ВР;Регистан, ВРК;Реглон Форте, ВР;Результат Супер, ВР;Ректон, ВР;Суховей, ВР;Тонгара, ВР;Эквит, ВР','2022-10-17 09:53:57'),(39,'Адексар, КЭ','Флуксопироксад + эпоксиконазол 62,5 + 62,5 г/л',NULL,'2022-10-17 09:53:57'),(40,'Аденго, КС','Изоксафлютол + тиенкарбазон-метил + антидот ципросульфамид 225 + 90 + 150 г/л',NULL,'2022-10-17 09:53:57'),(41,'Адмирал, КЭ','Пирипроксифен 100 г/л','Иноксифен, КЭ','2022-10-17 09:53:57'),(42,'Азорит, СК','Азоксистробин + ципроконазол 200 + 80 г/л','Амистар Нэкст, МД;Амистар Экстра, СК;Стробишанс Про, СК;Триактив Экстра, КС','2022-10-17 09:53:57'),(43,'Азорро, КС','Карбендазим + азоксистробин 300 + 100 г/л',NULL,'2022-10-17 09:53:57'),(44,'Айвенго, КЭ','Альфа-циперметрин 100 г/л','Аккорд, КЭ;АлтАльф, КЭ;Альтаир, КЭ;Альтерр, КЭ;Альфа Ринг, КЭ;Альфа-Ципи, КЭ;Альфабел, КЭ;Альфаметрин, КЭ;Альфатек, КЭ;Альфацин, КЭ;Армин, КЭ;Атрикс, КЭ;Мамба, КЭ;Неофрал, КЭ;Острог, МК;Пикет, КЭ;Фаскорд, КЭ;Фастак, КЭ;Фасшанс, КЭ;Фатрин, КЭ;Цезарь, КЭ;Цепеллин, КЭ;Ци-Альфа, КЭ;Цунами, КЭ','2022-10-17 09:53:57'),(45,'Айкон, КЭ','2,4-Д (малолетучие эфиры С7-С9) 550 г/л','Аминка ЭФ, КЭ;Левират, КЭ;Топтун, КЭ;Эфирам, КЭ;Эффект, КЭ','2022-10-17 09:53:57'),(46,'Аканто Плюс, КС','Пикоксистробин + Ципроконазол 200 +80 г/л',NULL,NULL),(47,'Акарб, ВДГ','Феноксикарб 250 г/кг',NULL,'2022-10-17 09:53:57'),(48,'Акардо, ККР','Спиродиклофен 250 г/л',NULL,'2022-10-17 09:53:57'),(49,'Акбарс, КЭ','Феноксапроп-П-этил + клоквинтосет-мексил 100+27 г/л',NULL,'2022-10-17 09:53:57'),(50,'Акзифор, КЭ','Оксифлуорфен 240 г/л','Акзифор, КЭ 1009;Босфор, КЭ;Галиган, КЭ;Гаур, КЭ;Гоал 2Е, КЭ;Пиранья, КЭ','2022-10-17 09:53:57'),(51,'Акзифор, КЭ 1009','Оксифлуорфен 240 г/л','Аксифор, КЭ;Босфор, КЭ;Галиган, КЭ;Гаур, КЭ;Гоал 2Е, КЭ;Пиранья, КЭ','2022-10-17 09:53:57'),(52,'Акиба, ВСК','Имидаклоприд 500 г/л','Табу, ВСК','2022-10-17 09:53:57'),(53,'Аккорд, КЭ','Альфа-циперметрин 100 г/л','Айвенго, КЭ;АлтАльф, КЭ;Альтаир, КЭ;Альтерр, КЭ;Альфа Ринг, КЭ;Альфа-Ципи, КЭ;Альфабел, КЭ;Альфаметрин, КЭ;Альфатек, КЭ;Альфацин, КЭ;Армин, КЭ;Атрикс, КЭ;Мамба, КЭ;Неофрал, КЭ;Острог, МК;Пикет, КЭ;Фаскорд, КЭ;Фастак, КЭ;Фасшанс, КЭ;Фатрин, КЭ;Цезарь, КЭ;Цепеллин, КЭ;Ци-Альфа, КЭ;Цунами, КЭ','2022-10-17 09:53:57'),(54,'Аккурат, ВДГ','Метсульфурон-метил 600 г/кг',NULL,'2022-10-17 09:53:57'),(55,'Акрис, СЭ','Диметенамид-Р + тербутилазин 280 + 250 г/л',NULL,'2022-10-17 09:53:57'),(56,'Акробат МЦ, ВДГ','Манкоцеб + диметоморф 600 + 90 г/кг',NULL,NULL),(57,'Акробат Топ, ВДГ','Диметоморф + дитианон 150 + 350 г/кг',NULL,NULL),(58,'Аксела, Г','Метальдегид 30 г/кг',NULL,'2022-10-17 09:53:57'),(59,'Аксиал 50, КЭ','Пиноксаден + антидот клоквинтосет-мексил 50 г/л + 12,5 г/л',NULL,'2022-10-17 09:53:57'),(60,'Аксакал, КЭ','Пиноксаден + антидот клоквинтосет-мексил 45 + 11,25 г/л',NULL,'2022-10-17 09:53:57'),(61,'Аксиома, КС','Карбендазим 500 г/л','Кредо, СК;Сарфун, СК;Доктор Кроп, КС;Зим 500, КС;Зимошанс, КС;Казим, КС;Казимир, КС;Карбезим, КС;Карбонар, КС;Кардинал 500, КС;Кардон, КС;Карзибел, КС;Комфорт, КС;Феразим, КС;Дерозал Евро, КС','2022-10-17 09:53:57'),(62,'Актара, ВДГ','Тиаметоксам 250 г/кг',NULL,'2022-10-17 09:53:57'),(63,'Актеллик, КЭ','Пиримифос-метил 500 г/л',NULL,'2022-10-17 09:53:57'),(64,'Актеон, ВР','Клопиралид + пиклорам 267 + 67 г/л',NULL,NULL),(65,'Актион, КС','Этофумезат 500 г/кг',NULL,'2022-10-17 09:53:57'),(66,'Акцент, КЭ','Клетодим + галоксифоп-Р-метил 150 + 75 г/л',NULL,NULL),(67,'Алатар, КЭ','Малатион + циперметрин 225 + 50 г/л',NULL,'2022-10-17 09:53:57'),(68,'Алгоритм, КЭ','Кломазон 480 г/л','БАМБУ, КЭ;Трейсер, КЭ;Камелин, КЭ;Клордин, КЭ;Комманд, КЭ','2022-10-17 09:53:57'),(69,'Алиос, КС','Тритиконазол 300 г/л',NULL,'2022-10-17 09:53:57'),(70,'Алиот, КЭ','Малатион 570 г/л',NULL,'2022-10-17 09:53:57'),(71,'Алирин-Б, Ж','Bacillus subtilis, штамм В-10 ВИЗР титр не менее 10^9 КОЕ/мл',NULL,'2022-10-17 09:53:57'),(72,'Алирин-Б, СП','Bacillus subtilis, штамм В-10 ВИЗР титр не менее 10^11 КОЕ/г',NULL,'2022-10-17 09:53:57'),(73,'Алирин-Б, ТАБ','Bacillus subtilis, штамм В-10 ВИЗР титр не менее 10*9 КОЕ/г',NULL,'2022-10-17 09:53:57'),(74,'Алистер Гранд, МД','Мезосульфурон-метил + йодосульфурон-метил-натрий + дифлюфеникан + мефенпир-диэти 6 + 4,5 + 180 + 27 г/л',NULL,'2022-10-17 09:53:57'),(75,'Аллерт, СТС','Тифенсульфурон-метил 750 г/кг','Алсион, ВДГ;Альфа-Гард, ВДГ;Купаж, ВДГ;Танит, МД;Тифенс, ВДГ;Тифи, ВДГ;ТифилАгро, ВДГ;Хармони Про, ВДГ;Хармони, СТС;Шансти, ВДГ','2022-10-17 09:53:57'),(76,'Алсион, ВДГ','Тифенсульфурон-метил 750 г/кг','Аллерт, СТС;Альфа-Гард, ВДГ;Купаж, ВДГ;Танит, МД;Тифенс, ВДГ;Тифи, ВДГ;ТифилАгро, ВДГ;Хармони Про, ВДГ;Хармони, СТС;Шансти, ВДГ','2022-10-17 09:53:57'),(77,'Алтис, ВДГ','Римсульфурон 250 г/кг','Арпад, ВДГ;Гримс, ВДГ;Денди, СТС;Кассиус, ВРП;Маис, СТС;Ранголи-Тиран, ВДГ;Риманол, ВДГ;Римлин, ВДГ;Римус, ВДГ;Римэкс, ВДГ;Ромул, ВДГ;Титус, СТС;Тример, ВДГ;Цицерон, ВДГ;Шантус, ВДГ','2022-10-17 09:53:57'),(78,'АлтСил, КС','Тебуконазол 60 г/л','Раксон, КС;Стингер, КС;Тебу 60, МЭ;Тебузан, ТКС;Террасил, КС;Экономикс Колор, КС;Бункер, ВСК;Грандсил, КС;Доспех, КС;Редут, КС;Сфинкс, КС;Тебуконазол, КС;Фразол Классик, КС','2022-10-17 09:53:57'),(79,'Альбит, ТПС','Поли-бета-гидроксимасляная кислота + магний сернокислый + калий фосфорнокислый + калий азотнокислый + карбамид 6,2 + 29,8 + 91,1 + 91,2 + 181,5 г/кг','Альбит, ТПС (РРС);Экопин, ТПС','2022-10-17 09:53:57'),(80,'Альбит, ТПС (РРС)','Поли-бета-гидроксимасляная кислота + магний сернокислый + калий фосфорнокислый + калий азотнокислый + карбамид 6,2 + 29,8 + 91,1 + 91,2 + 181,5 г/кг','Альбит, ТПС;Экопин, ТПС','2022-10-17 09:53:57'),(81,'Алькасар, КС','Дифеноконазол + Ципроконазол 30 + 6,3 г/л',NULL,NULL),(82,'Алькор, КС','Ципроконазол 400 г/л',NULL,'2022-10-17 09:53:57'),(83,'Альпари, КЭ','Пропиконазол + ципроконазол 250 + 80 г/л','Аваксс, КЭ;Альтазол, КЭ;Альто Супер, КЭ;Альтрум Супер, КЭ;Анемон, КЭ;Атлант Супер, КЭ;Виртуоз, КЭ;Золтан, КЭ;Калибел, КЭ;Маэстро, КЭ;Пропишанс Супер, КЭ;Профи Супер, КЭ;Ранголи-Ципрос, КЭ;Супер Альянс, КЭ;Фильтерр, КЭ;Фунгисил, КЭ;Цимус Прогресс, КЭ;Цимус Прогресс, КЭ 1574','2022-10-17 09:53:57'),(84,'Альтазол, КЭ','Пропиконазол + ципроконазол 250 + 80 г/л','Аваксс, КЭ;Альпари, КЭ;Альто Супер, КЭ;Альтрум Супер, КЭ;Анемон, КЭ;Атлант Супер, КЭ;Виртуоз, КЭ;Золтан, КЭ;Калибел, КЭ;Маэстро, КЭ;Пропишанс Супер, КЭ;Профи Супер, КЭ;Ранголи-Ципрос, КЭ;Супер Альянс, КЭ;Фильтерр, КЭ;Фунгисил, КЭ;Цимус Прогресс, КЭ;Цимус Прогресс, КЭ 1574','2022-10-17 09:53:57'),(85,'Альтаир, КЭ','Альфа-циперметрин 100 г/л','Айвенго, КЭ;Аккорд, КЭ;АлтАльф, КЭ;Альтерр, КЭ;Альфа Ринг, КЭ;Альфа-Ципи, КЭ;Альфабел, КЭ;Альфаметрин, КЭ;Альфатек, КЭ;Альфацин, КЭ;Армин, КЭ;Атрикс, КЭ;Мамба, КЭ;Неофрал, КЭ;Острог, МК;Пикет, КЭ;Фаскорд, КЭ;Фастак, КЭ;Фасшанс, КЭ;Фатрин, КЭ;Цезарь, КЭ;Цепеллин, КЭ;Ци-Альфа, КЭ;Цунами, КЭ','2022-10-17 09:53:57'),(86,'Альтерр, КЭ','Альфа-циперметрин 100 г/л','Айвенго, КЭ;Аккорд, КЭ;АлтАльф, КЭ;Альтаир, КЭ;Альфа Ринг, КЭ;Альфа-Ципи, КЭ;Альфабел, КЭ;Альфаметрин, КЭ;Альфатек, КЭ;Альфацин, КЭ;Армин, КЭ;Атрикс, КЭ;Мамба, КЭ;Неофрал, КЭ;Острог, МК;Пикет, КЭ;Фаскорд, КЭ;Фастак, КЭ;Фасшанс, КЭ;Фатрин, КЭ;Цезарь, КЭ;Цепеллин, КЭ;Ци-Альфа, КЭ;Цунами, КЭ','2022-10-17 09:53:57'),(87,'Альто Супер, КЭ','Пропиконазол + ципроконазол 250 + 80 г/л','Аваксс, КЭ;Альпари, КЭ;Альтазол, КЭ;Альтрум Супер, КЭ;Анемон, КЭ;Атлант Супер, КЭ;Виртуоз, КЭ;Золтан, КЭ;Калибел, КЭ;Маэстро, КЭ;Пропишанс Супер, КЭ;Профи Супер, КЭ;Ранголи-Ципрос, КЭ;Супер Альянс, КЭ;Фильтерр, КЭ;Фунгисил, КЭ;Цимус Прогресс, КЭ;Цимус Прогресс, КЭ 1574','2022-10-17 09:53:57'),(88,'Альто Турбо, КЭ','Пропиконазол + ципроконазол 250 + 160 г/л',NULL,'2022-10-17 09:53:57'),(89,'Альтруист, КЭ','Азоксистробин + Тебуконазол 60 + 100 г/л',NULL,'2022-10-17 09:53:57'),(90,'Альтруист, СК','Азоксистробин + тебуконазол 60 + 100 г/л',NULL,'2022-10-17 09:53:57'),(91,'Альтрум Супер, КЭ','Пропиконазол + ципроконазол 250 + 80 г/л','Аваксс, КЭ;Альпари, КЭ;Альтазол, КЭ;Альто Супер, КЭ;Анемон, КЭ;Атлант Супер, КЭ;Виртуоз, КЭ;Золтан, КЭ;Калибел, КЭ;Маэстро, КЭ;Пропишанс Супер, КЭ;Профи Супер, КЭ;Ранголи-Ципрос, КЭ;Супер Альянс, КЭ;Фильтерр, КЭ;Фунгисил, КЭ;Цимус Прогресс, КЭ;Цимус Прогресс, КЭ 1574','2022-10-17 09:53:57'),(92,'Альфа Атаман, ВР','Глифосат (изопропиламинная соль) 360 г/л','Ампир, ВР;Аргумент, ВР;Гелиос, ВР;Глибел, ВР;ГлиБест, ВР;Глифид, ВР;Глифоголд, ВР;Глифор, ВР;Глифот, ВР;Глифошанс, ВР;Граунд, ВР;Дзюдо, ВР;Зеро, ВР;Кайман, ВР;Ликвидатор, ВР;Напалм, ВР;Пилараунд, ВР;Рауль, ВР;Раундап Макс, ВР;Раундап, ВР;Росейт, ВР;Спрут, ВР;Тайфун, ВР;Торнадо, ВР;Торнадо, ВР 2585;Тотал, ВР;Файтер, ВР;Факел, ВР;Чистогряд, ВР','2022-10-17 09:53:57'),(93,'АЛЬФА БРИГАДИР, КЭ','Этофумезат + фенмедифам + десмедифам 112 + 91 + 71 г/л',NULL,'2022-10-17 09:53:57'),(94,'Альфа Ринг, КЭ','Альфа-циперметрин 100 г/л','Айвенго, КЭ;Аккорд, КЭ;АлтАльф, КЭ;Альтаир, КЭ;Альтерр, КЭ;Альфа-Ципи, КЭ;Альфабел, КЭ;Альфаметрин, КЭ;Альфатек, КЭ;Альфацин, КЭ;Армин, КЭ;Атрикс, КЭ;Мамба, КЭ;Неофрал, КЭ;Острог, МК;Пикет, КЭ;Фаскорд, КЭ;Фастак, КЭ;Фасшанс, КЭ;Фатрин, КЭ;Цезарь, КЭ;Цепеллин, КЭ;Ци-Альфа, КЭ;Цунами, КЭ','2022-10-17 09:53:57'),(95,'Альфа Стар, ВДГ','Трибенурон-метил 750 г/кг','Агростар, ВДГ;Аргамак, ВДГ;Аргамак, ВДГ-1001;Артстар, ВДГ;Бен Гур, ВДГ;Бенрил, ВДГ;Гекстар, ВДГ;Герсотил, ВДГ;Герсотил, ВДГ+;Гран-при, ВДГ;Гранат, ВДГ;Гранд Плюс, ВДГ;Гранилин, ВДГ;Гренадер, ВДГ;Громстор, ВДГ;Грэнери, ВДГ;Гюрза, СП;Коррида, ВДГ;Мортира, ВДГ;Норман, ВДГ;Прометей, ВДГ;Ранголи-Трибенурон, ВДГ;Санфло, ВДГ;Спецназ 750, ВДГ;Сталкер, ВДГ;Старбокс, СТС;Суперстар, ВДГ;Таллер, ВДГ;Террастар, ВДГ;ТриАлт, ВДГ;Трибел, ВДГ;Трибинстар, ВДГ;Трибун, СТС;Трибунал, ВДГ;Тризлак, ВДГ;Триметил, ВДГ;Триммер, ВДГ;Ферат, ВДГ;Флюенс, ВДГ;Химстар, ВДГ;Шанстар, ВДГ;Экспресс, ВДГ','2022-10-17 09:53:57'),(96,'Альфа Тигр, КЭ','Хизалофоп-П-этил 50 г/л',NULL,'2022-10-17 09:53:57'),(97,'Альфа Феникс, КС','Флутриафол 250 г/л',NULL,'2022-10-17 09:53:57'),(98,'Альфа-Амиприд, РП','Ацетамиприд 200 г/кг',NULL,'2022-10-17 09:53:57'),(99,'Альфабел, КЭ','Альфа-циперметрин 100 г/л','Айвенго, КЭ;Аккорд, КЭ;АлтАльф, КЭ;Альтаир, КЭ;Альтерр, КЭ;Альфа Ринг, КЭ;Альфа-Ципи, КЭ;Альфаметрин, КЭ;Альфатек, КЭ;Альфацин, КЭ;Армин, КЭ;Атрикс, КЭ;Мамба, КЭ;Неофрал, КЭ;Острог, МК;Пикет, КЭ;Фаскорд, КЭ;Фастак, КЭ;Фасшанс, КЭ;Фатрин, КЭ;Цезарь, КЭ;Цепеллин, КЭ;Ци-Альфа, КЭ;Цунами, КЭ','2022-10-17 09:53:57'),(100,'Альфа-Бентазон, ВР','Бентазон 480 г/л','АгроБазон, ВР;Альфа-бентазон, ВР;Базон, ВР;Барон, ВР;Базагран, BР;Бентазолин, ВР;Бентасил, ВР;Бентекс, ВР;Бентобел, ВР;Бентограм, ВР;Бентус, ВР;Бизон, ВК;Бонус, ВР;Бунт, ВР;Гарнизон, ВР;Гранбаз, ВР;Изобен, ВР;Корсар, ВРК;Наношанс, ВР;Ранголи-Базорон, ВР;Сикурс, ВР;Тигрис, ВР','2022-10-17 09:53:57'),(101,'Альфа-Гард, ВДГ','Тифенсульфурон-метил 750 г/кг','Алсион, ВДГ;Аллерт, СТС;Купаж, ВДГ;Танит, МД;Тифенс, ВДГ;Тифи, ВДГ;ТифилАгро, ВДГ;Хармони Про, ВДГ;Хармони, СТС;Шансти, ВДГ','2022-10-17 09:53:57'),(102,'Альфа-Дикамба, ВРК','Дикамба (диметиламинная соль) 480 г/л','Адвокат, ВР;Витара, ВР;Герб-480, ВР;Губернатор, ВР;Дамба, ВР;Девиз, ВР;Деймос, ВРК;Декабрист, ВР;Диамант, ВР;Дианат, ВР;Диастар, ВР;Дикамбел, ВР;Ларт, ВР;Мономакс, ВР;Мурал, ВР;Оптимум, ВР;Санпэй, ВР;Шанс ДКБ, ВР','2022-10-17 09:53:57'),(103,'Альфа-Дикват, ВР','Дикват (дибромид) 150 г/л','Абидос, ВР;Адекват, ВР;Волат, ВР;Голден Ринг, ВР;Десикант Экспертоф, ВР;Десикат Супер, ВР;Дикват, ВРК;Дикватерр Супер, ВР;Дикошанс, ВР;Донат, ВР;Лост, ВР;Молоток, ВР;Полис, ВР;Ранголи-Реголон, ВР;Регистан, ВРК;Реглон Форте, ВР;Результат Супер, ВР;Ректон, ВР;Суховей, ВР;Тонгара, ВР;Эквит, ВР','2022-10-17 09:53:57'),(104,'Альфа-Директор, КЭ','Диметоат 400 г/л','Евродим, КЭ;Би-58 Топ, КЭ;Бинадин, КЭ;Бишка, КЭ;Данадим Эксперт, КЭ;Ди-68, КЭ;Диметрон, КЭ;Диметус, КЭ;Димефос, КЭ;Дишанс, КЭ;Евродим, КЭ;Ранголи-Дункан, КЭ;Рогор-С, КЭ;Сирокко, КЭ;Тагор, КЭ;Террадим, КЭ;Тод, КЭ;Фостран, КЭ','2022-10-17 09:53:57'),(105,'Альфа-Пиралид, ВР','Клопиралид 300 г/л','Агрон, ВР;Бис-300, ВР;Газонтрел, ВР;Клорит, ВР;Корректор, ВР;Лонган, ВР;Лонтрел-300, ВР;Лорнет, ВР;Премьер 300, ВР;Хакер 300, ВР;Хатор, ВР;Цукрон+, ВР;Шанстрел 300, ВР','2022-10-17 09:53:57'),(106,'Альфаплан, КС','Альфа-циперметрин 200 г/л',NULL,'2022-10-17 09:53:57'),(107,'Альфа-Прометрин, КС','Прометрин 500 г/л',NULL,'2022-10-17 09:53:57'),(108,'Альфа-Протравитель, ТКС','Имазалил + тебуконазол 100 + 60 г/л',NULL,'2022-10-17 09:53:57'),(109,'Альфа-Серф, ВК','Имидаклоприд 200 г/л',NULL,'2022-10-17 09:53:57'),(110,'Альфастим, ВЭ','Тритерпеновые кислоты 100 г/л','Биосил, ВЭ;Новосил, ВЭ','2022-10-17 09:53:57'),(111,'Альфа-Ципи, КЭ','Альфа-циперметрин 100 г/л','Айвенго, КЭ;Аккорд, КЭ;АлтАльф, КЭ;Альтаир, КЭ;Альтерр, КЭ;Альфа Ринг, КЭ;Альфабел, КЭ;Альфаметрин, КЭ;Альфатек, КЭ;Альфацин, КЭ;Армин, КЭ;Атрикс, КЭ;Мамба, КЭ;Неофрал, КЭ;Острог, МК;Пикет, КЭ;Фаскорд, КЭ;Фастак, КЭ;Фасшанс, КЭ;Фатрин, КЭ;Цезарь, КЭ;Цепеллин, КЭ;Ци-Альфа, КЭ;Цунами, КЭ','2022-10-17 09:53:57'),(112,'Альфин, ТАБ','Алюминия фосфид 560 г/кг','Фосфин, ТАБ;',NULL),(113,'Альянс, ВР','2,4-Д + дикамба (диметиламинные соли) 344 + 120 г/л','Всполох, ВР ;Диакем, ВР;Диамакс, ВР ;Диана, ВР ;Дикопур Топ, ВР ;Диален Супер, ВР ','2022-10-17 09:53:57'),(114,'Аметил, ВРК','МЦПА (диметиламинная + калиевая + натриевая соли, смесь) 500 г/л МЦПА к-ты','Агрошанс, ВК;Агритокс, ВК;Гербитокс, ВРК;Линтаплант, ВК','2022-10-17 09:53:57'),(115,'Аминка ФЛО, КЭ','2,4-Д (малолетучие эфиры С7-С9) + флорасулам 550 г/л + 7,4 г/л','Балет, КЭ;Дива, КС','2022-10-17 09:53:57'),(116,'Аминка ЭФ, КЭ','2,4-Д (малолетучие эфиры С7-С9) 550 г/л','Айкон, КЭ;Левират, КЭ;Топтун, КЭ;Эфирам, КЭ;Эффект, КЭ','2022-10-17 09:53:57'),(117,'Аминка, ВР','2,4-Д (диметиламинная соль) 600 г/л','Дикамин-Д, ВР;Аминопелик, ВР;Диамисоль, ВР','2022-10-17 09:53:57'),(118,'Аминопелик, ВР','2,4-Д (диметиламинная соль) 600 г/л 2,4-Д к-ты','Аминка, ВР;Дикамин-Д, ВР;Диамисоль, ВР','2022-10-17 09:53:57'),(119,'Амистар Голд, СК','Азоксистробин + дифеноконазол 125 + 125 г/л',NULL,'2022-10-17 09:53:57'),(120,'Амистар Нэкст, МД','Азоксистробин + Ципроконазол 200 г/л + 80 г/л','Азорит, СК;Амистар Экстра, СК;Стробишанс Про, СК;Триактив Экстра, КС','2022-10-17 09:53:57'),(121,'Амистар Топ, СК','Азоксистробин + дифеноконазол 200 + 125 г/л',NULL,'2022-10-17 09:53:57'),(122,'Амистар Трио, КЭ','Пропиконазол + азоксистробин + ципроконазол 125 + 100 + 30 г/л',NULL,'2022-10-17 09:53:57'),(123,'Амистар Экстра, СК','Азоксистробин + ципроконазол 200 + 80 г/л','Азорит, СК;Амистар Нэкст, МД;Стробишанс Про, СК;Триактив Экстра, КС','2022-10-17 09:53:57'),(124,'Ампир Экстра, ВР','Глифосат (калийная соль) 540 г/л глифосата к-ты',NULL,'2022-10-17 09:53:57'),(125,'Ампир, ВР','Глифосат (изопропиламинная соль) 360 г/л','Альфа Атаман, ВР;Аргумент, ВР;Гелиос, ВР;Глибел, ВР;ГлиБест, ВР;Глифид, ВР;Глифоголд, ВР;Глифор, ВР;Глифот, ВР;Глифошанс, ВР;Граунд, ВР;Дзюдо, ВР;Зеро, ВР;Кайман, ВР;Ликвидатор, ВР;Напалм, ВР;Пилараунд, ВР;Рауль, ВР;Раундап Макс, ВР;Раундап, ВР;Росейт, ВР;Спрут, ВР;Тайфун, ВР;Торнадо, ВР;Торнадо, ВР 2585;Тотал, ВР;Файтер, ВР;Факел, ВР;Чистогряд, ВР','2022-10-17 09:53:57'),(126,'Амплиго, МКС','Лямбда-цигалотрин + хлорантранилипрол 50 + 100 г/л',NULL,'2022-10-17 09:53:57'),(127,'Анаконда, КЭ','С-Метолахлор 960 г/л',NULL,'2022-10-17 09:53:57'),(128,'Анемон, КЭ','Пропиконазол + Ципроконазол 250 + 80 г/л',NULL,NULL),(129,'Анкор-85, ВДГ','Сульфометурон-метил (калиевая соль) 750 г/кг',NULL,'2022-10-17 09:53:57'),(130,'Ансамбль, КС','Тиабендазол + флутриафол 25 + 25 г/л',NULL,'2022-10-17 09:53:57'),(131,'Антарес, ВК','МЦПА + кислоты (смесь диметиламинной, калиевой, натриевой солей) 500 г/л',NULL,'2022-10-17 09:53:57'),(132,'Антивылегач, BP','Хлормекватхлорид 675 г/л',NULL,'2022-10-17 09:53:57'),(133,'Антиклещ, КЭ','Малатион 525 г/л',NULL,'2022-10-17 09:53:57'),(134,'Антитлин, П','Никотин 9 г/кг',NULL,'2022-10-17 09:53:57'),(135,'Антракол, ВДГ','Пропинеб 700 г/кг',NULL,'2022-10-17 09:53:57'),(136,'Аполло, КС','Клофентезин 500 г/л',NULL,'2022-10-17 09:53:57'),(137,'Апплауд, СП','Бупрофезин 250 г/кг',NULL,'2022-10-17 09:53:57'),(138,'Априори, ВДГ','Мезотрион + Никосульфурон 570 г/кг + 230 г/кг',NULL,'2022-10-17 09:53:57'),(140,'Апрон Голд, ВЭ','Мефеноксам 350 г/л',NULL,'2022-10-17 09:53:57'),(141,'Арбалет, СЭ','2,4-Д (2-этилгексиловый эфир)+ флорасулам) 300 г/л +6,25 г/л','Дисулам, СЭ;Люгер, СЭ;Опричник, СЭ;Премьера, СЭ;Флорастар, СЭ;Камаро, СЭ','2022-10-17 09:53:57'),(142,'Арбитр АГ, СП','Трифлусульфурон-метил 500 г/кг','Арбитр, СП;БитЛайт, КС;Караван, СП;Карамболь, СП;Кари-Макс, СП;Карибу С, ВДГ;Карибу, ВДГ;КариПро, ВДГ;Каришанс, ВДГ;Карнаби, ВДГ;Карриджу, ВДГ;Кондор, ВДГ;Малибу, ВДГ;Олимп, ВДГ;Рандеву, ВДГ;Флуорон, ВДГ;Форинт, ВДГ;Фурон, ВДГ','2022-10-17 09:53:57'),(143,'Арбитр, СП','Трифлусульфурон-метил 500 г/кг','Арбитр АГ, СП;БитЛайт, КС;Караван, СП;Карамболь, СП;Кари-Макс, СП;Карибу С, ВДГ;Карибу, ВДГ;КариПро, ВДГ;Каришанс, ВДГ;Карнаби, ВДГ;Карриджу, ВДГ;Кондор, ВДГ;Малибу, ВДГ;Олимп, ВДГ;Рандеву, ВДГ;Флуорон, ВДГ;Форинт, ВДГ;Фурон, ВДГ','2022-10-17 09:53:57'),(144,'Арбонал, ВК','Имазапир 250 г/л','Ас, ВК;Грейдер, ВГР;Шквал, ВК','2022-10-17 09:53:57'),(145,'Аргамак, ВДГ','Трибенурон-метил 750 г/кг','Агростар, ВДГ;Альфа Стар, ВДГ;Аргамак, ВДГ-1001;Артстар, ВДГ;Бен Гур, ВДГ;Бенрил, ВДГ;Гекстар, ВДГ;Герсотил, ВДГ;Герсотил, ВДГ+;Гран-при, ВДГ;Гранат, ВДГ;Гранд Плюс, ВДГ;Гранилин, ВДГ;Гренадер, ВДГ;Громстор, ВДГ;Грэнери, ВДГ;Гюрза, СП;Коррида, ВДГ;Мортира, ВДГ;Норман, ВДГ;Прометей, ВДГ;Ранголи-Трибенурон, ВДГ;Санфло, ВДГ;Спецназ 750, ВДГ;Сталкер, ВДГ;Старбокс, СТС;Суперстар, ВДГ;Таллер, ВДГ;Террастар, ВДГ;ТриАлт, ВДГ;Трибел, ВДГ;Трибинстар, ВДГ;Трибун, СТС;Трибунал, ВДГ;Тризлак, ВДГ;Триметил, ВДГ;Триммер, ВДГ;Ферат, ВДГ;Флюенс, ВДГ;Химстар, ВДГ;Шанстар, ВДГ;Экспресс, ВДГ','2022-10-17 09:53:57'),(146,'АРГО, МЭ','Феноксапроп-П-этил + клодинафоп-пропаргил + мефенпир-диэтил 80 + 24 + 30 г/л',NULL,'2022-10-17 09:53:57'),(147,'Аргумент Стар, ВР','Глифосат (калийная соль) 540 г/л','Вольник, ВР;Голиаф, ВР;Торнадо 540, ВР;Аристократ Супер, ВР;Тачдаун, ВР;ГлиБест 540, ВР;Глифошанс Супер, ВР;Силач, ВР;Спрут Экстра, ВР','2022-10-17 09:53:57'),(148,'Аргумент, ВР','Глифосат (изопропиламинная соль) 360 г/л','Альфа Атаман, ВР;Ампир, ВР;Гелиос, ВР;Глибел, ВР;ГлиБест, ВР;Глифид, ВР;Глифоголд, ВР;Глифор, ВР;Глифот, ВР;Глифошанс, ВР;Граунд, ВР;Дзюдо, ВР;Зеро, ВР;Кайман, ВР;Ликвидатор, ВР;Напалм, ВР;Пилараунд, ВР;Рауль, ВР;Раундап Макс, ВР;Раундап, ВР;Росейт, ВР;Спрут, ВР;Тайфун, ВР;Торнадо, ВР;Торнадо, ВР 2585;Тотал, ВР;Файтер, ВР;Факел, ВР;Чистогряд, ВР','2022-10-17 09:53:57'),(149,'Аристократ Супер, ВР','Глифосат (калийная соль) 540 г/л','Аргумент Стар, ВР;Вольник, ВР;Голиаф, ВР;Торнадо 540, ВР;Тачдаун, ВР;ГлиБест 540, ВР;Глифошанс Супер, ВР;Силач, ВР;Спрут Экстра, ВР','2022-10-17 09:53:57'),(150,'Аристократ, ВР','Глифосат (изопропиламинная соль) 480 г/л','Напалм-480, ВР;Ранголи-Глифосат 480, ВР','2022-10-17 09:53:57'),(151,'Ария, КС','Фипронил 250 г/л','Койра, КС;Скутум, СК','2022-10-17 09:53:57'),(152,'Аркан, ВДГ','Римсульфурон + тифенсульфурон-метил + флорасулам 250 + 150 + 80 г/кг',NULL,'2022-10-17 09:53:57'),(153,'Армин, КЭ','Альфа-циперметрин 100 г/л','Айвенго, КЭ;Аккорд, КЭ;АлтАльф, КЭ;Альтаир, КЭ;Альтерр, КЭ;Альфа Ринг, КЭ;Альфа-Ципи, КЭ;Альфабел, КЭ;Альфаметрин, КЭ;Альфатек, КЭ;Альфацин, КЭ;Атрикс, КЭ;Мамба, КЭ;Неофрал, КЭ;Острог, МК;Пикет, КЭ;Фаскорд, КЭ;Фастак, КЭ;Фасшанс, КЭ;Фатрин, КЭ;Цезарь, КЭ;Цепеллин, КЭ;Ци-Альфа, КЭ;Цунами, КЭ','2022-10-17 09:53:57'),(154,'Арпад, ВДГ','Римсульфурон 250 г/кг','Алтис, ВДГ;Гримс, ВДГ;Денди, СТС;Кассиус, ВРП;Маис, СТС;Ранголи-Тиран, ВДГ;Риманол, ВДГ;Римлин, ВДГ;Римус, ВДГ;Римэкс, ВДГ;Ромул, ВДГ;Титус, СТС;Тример, ВДГ;Цицерон, ВДГ;Шантус, ВДГ','2022-10-17 09:53:57'),(155,'Арриво, КЭ','Циперметрин 250 г/л',NULL,'2022-10-17 09:53:57'),(156,'Артафит, ВРК','Полидиаллилдиметиламмоний хлорид 100 г/л',NULL,'2022-10-17 09:53:57'),(157,'Артист, ВДГ','Флуфенацет + метрибузин 240 + 175 г/кг',NULL,'2022-10-17 09:53:57'),(158,'Артстар, ВДГ','Трибенурон-метил 750 г/кг','Агростар, ВДГ;Альфа Стар, ВДГ;Аргамак, ВДГ;Аргамак, ВДГ-1001;Артстар, ВДГ;Бен Гур, ВДГ;Бенрил, ВДГ;Гекстар, ВДГ;Герсотил, ВДГ;Герсотил, ВДГ+;Гран-при, ВДГ;Гранат, ВДГ;Гранд Плюс, ВДГ;Гранилин, ВДГ;Гренадер, ВДГ;Громстор, ВДГ;Грэнери, ВДГ;Гюрза, СП;Коррида, ВДГ;Мортира, ВДГ;Норман, ВДГ;Прометей, ВДГ;Ранголи-Трибенурон, ВДГ;Санфло, ВДГ;Спецназ 750, ВДГ;Сталкер, ВДГ;Старбокс, СТС;Суперстар, ВДГ;Таллер, ВДГ;Террастар, ВДГ;ТриАлт, ВДГ;Трибел, ВДГ;Трибинстар, ВДГ;Трибун, СТС;Трибунал, ВДГ;Тризлак, ВДГ;Триметил, ВДГ;Триммер, ВДГ;Ферат, ВДГ;Флюенс, ВДГ;Химстар, ВДГ;Шанстар, ВДГ;Экспресс, ВДГ','2022-10-17 09:53:57'),(159,'Архитект, СЭ','Пираклостробин + прогексадион кальция + мепикват-хлорид 100 + 25 + 150 г/л',NULL,'2022-10-17 09:53:57'),(160,'Ас, ВК','Имазапир 250 г/л','Арбонал, ВК;Грейдер, ВГР;Шквал, ВК','2022-10-17 09:53:57'),(161,'Аспид, СК','Тиаклоприд 480 г/л',NULL,'2022-10-17 09:53:57'),(162,'Ассолюта Прайм, МК','2,4-Д (сложный 2-этилгексиловый эфир) + флорасулам 410 + 15 г/л','Балерина Супер, СЭ','2022-10-17 09:53:57'),(163,'Ассолюта, МК','2,4-Д (сложный 2-этилгексиловый эфир) + флорасулам 300 г/л + 5,35 г/л',NULL,'2022-10-17 09:53:57'),(164,'Астэрикс, СЭ','2,4-Д (сложный 2-этилгексиловый эфир) + флорасулам 300 г/л + 6,25 г/л','Ламбада, СЭ;Подмарин, КЭ;Прима, СЭ;Примавера, СЭ;Пришанс, СЭ','2022-10-17 09:53:57'),(165,'Атаброн, КС','Хлорфлуазурон 107 г/л',NULL,'2022-10-17 09:53:57'),(166,'Атлант Супер, КЭ','Пропиконазол + Ципроконазол 250 + 80 г/л',NULL,NULL),(167,'Атлант, КЭ','Пропиконазол 250 г/л','Пеон, КЭ;Агролекарь, КЭ;Прогноз, КЭ;Профи, КЭ;Профикс, КЭ;Скиф, КЭ;Тилт, КЭ;Тимус, КЭ;Пропи Плюс, КЭ;ПропиШанс, КЭ;Титан, КЭ;Чистофлор, КЭ','2022-10-17 09:53:57'),(168,'Атлет, ВР','Хлормекватхлорид 600 г/л',NULL,'2022-10-17 09:53:57'),(170,'Атоник Плюс, ВР','Пара-нитрофенолят натрия + орто-нитрофенолят натрия + 5-нитрогваяколят натрия 9 + 6 + 3 г/л',NULL,'2022-10-17 09:53:57'),(171,'Атрикс, КЭ','Альфа-циперметрин 100 г/л','Айвенго, КЭ;Аккорд, КЭ;АлтАльф, КЭ;Альтаир, КЭ;Альтерр, КЭ;Альфа Ринг, КЭ;Альфа-Ципи, КЭ;Альфабел, КЭ;Альфаметрин, КЭ;Альфатек, КЭ;Альфацин, КЭ;Армин, КЭ;Мамба, КЭ;Неофрал, КЭ;Острог, МК;Пикет, КЭ;Фаскорд, КЭ;Фастак, КЭ;Фасшанс, КЭ;Фатрин, КЭ;Цезарь, КЭ;Цепеллин, КЭ;Ци-Альфа, КЭ;Цунами, КЭ','2022-10-17 09:53:57'),(172,'АтронПро, ВДГ','Имазапир + сульфометурон-метил 250 + 75 г/кг',NULL,NULL),(173,'Аттик, КС','Дифеноконазол + ципроконазол 30 + 6,3 г/л','Алькасар, КС;Даймонд Супер, КС;ДВД Шанс, КС;Дивиденд Стар, КС','2022-10-17 09:53:57'),(174,'Аффет, КС','Пентиопирад 200 г/л',NULL,'2022-10-17 09:53:57'),(175,'Ацетал Про, КЭ','Пропизохлор 720 г/л',NULL,'2022-10-17 09:53:57'),(176,'Ацидан, СП','Манкоцеб + Металаксил 640 + 80 г/кг',NULL,'2022-10-17 09:53:57'),(177,'Ацифект, ККР','Ацифлуорфен 250 г/л',NULL,'2022-10-17 09:53:57'),(178,'Б-360, ВР','Липо-хитоолигосахариды 1х10* -6 г/л',NULL,'2022-10-17 09:53:57'),(179,'Багира, КЭ','Квизалофоп-П-тефурил 40 г/л','Лемур, КЭ;Пантера, КЭ;Хилер, МКЭ','2022-10-17 09:53:57'),(180,'Багрец, КС','Флудиоксонил + азоксистробин 50 + 21 г/л',NULL,'2022-10-17 09:53:57'),(181,'Базагран, BР','Бентазон 480 г/л','АгроБазон, ВР;Альфа-бентазон, ВР;Базон, ВР;Барон, ВР;Бентазолин, ВР;Бентасил, ВР;Бентекс, ВР;Бентобел, ВР;Бентограм, ВР;Бентус, ВР;Бизон, ВК;Бонус, ВР;Бунт, ВР;Гарнизон, ВР;Гранбаз, ВР;Изобен, ВР;Корсар, ВРК;Наношанс, ВР;Ранголи-Базорон, ВР;Сикурс, ВР;Тигрис, ВР','2022-10-17 09:53:57'),(182,'Базис, СТС','Римсульфурон + тифенсульфурон-метил 500 + 250 г/кг','Тезис, ВДГ','2022-10-17 09:53:57'),(183,'Базон, ВР','Бентазон 480 г/л','АгроБазон, ВР;Альфа-бентазон, ВР;Барон, ВР;Базагран, BР;Бентазолин, ВР;Бентасил, ВР;Бентекс, ВР;Бентобел, ВР;Бентограм, ВР;Бентус, ВР;Бизон, ВК;Бонус, ВР;Бунт, ВР;Гарнизон, ВР;Гранбаз, ВР;Изобен, ВР;Корсар, ВРК;Наношанс, ВР;Ранголи-Базорон, ВР;Сикурс, ВР;Тигрис, ВР','2022-10-17 09:53:57'),(184,'Байзафон, СП','Триадимефон 250 г/кг',NULL,'2022-10-17 09:53:57'),(185,'Бакара Форте, КС','Дифлюфеникан + флуфенацет + флуртамон 120 +120 +120 г/л',NULL,'2022-10-17 09:53:57'),(186,'Баксис, Ж','Bacillus subtilis титр не менее 10*9 КОЕ/мл',NULL,'2022-10-17 09:53:57'),(187,'Бактерра, СП','Bacillus subtilis титр не менее 10*9 КОЕ/г',NULL,'2022-10-17 09:53:57'),(188,'Бактороденцид, ПР','Salmonella enteritidis, var. Issatschenko, 29/1 титр не менее 1-3 млрд/г',NULL,'2022-10-17 09:53:57'),(189,'Бактофит, СП','Bacillus subtilis, штамм ИПМ 215 БА-10000 ЕА/г, титр не менее 2 млрд спор/г',NULL,'2022-10-17 09:53:57'),(190,'Бактофит, СК','Bacillus subtilis, штамм ИПМ 215 БА-10000 ЕА/мл, титр не менее 2 млрд спор/мл',NULL,'2022-10-17 09:53:57'),(191,'Бактофорт, Ж','Bacillus subtilis, штаммВ-2918 + Bacillus amyloliquefaciens, штаммИМВВ-7100 титр не менее 2,5 млрд КОЕ/мл + титр не менее 2,5 млрд КОЕ/мл',NULL,'2022-10-17 09:53:57'),(192,'Балерина Супер, СЭ','2,4-Д (сложный 2-этилгексиловый эфир) + флорасулам 410 + 15 г/л',NULL,NULL),(193,'Балерина Форте, СЭ','2,4-Д (сложный 2-этилгексиловый эфир) + пиклорам + флорасулам 300 + 37,5 + 10 г/л',NULL,'2022-10-17 09:53:57'),(194,'Балерина, СЭ','2,4-Д (сложный 2-этилгексиловый эфир) + флорасулам 410 + 7,4 г/л',NULL,'2022-10-17 09:53:57'),(195,'Балет, КЭ','2,4-Д (малолетучие эфиры С7-С9) + флорасулам 550 + 7,4 г/л','Аминка ФЛО, Дива, КС','2022-10-17 09:53:57'),(196,'Балий, КМЭ','Пропиконазол + азоксистробин 180 + 120 г/л',NULL,'2022-10-17 09:53:57'),(197,'Балинт, КС','Флутриафол + тиабендазол + имазалил 37,5 + 25 + 15 г/л',NULL,NULL),(198,'БАМБУ, КЭ','Кломазон 480 г/л','Алгоритм, КЭ;Трейсер, КЭ;Камелин, КЭ;Клордин, КЭ;Комманд, КЭ','2022-10-17 09:53:57'),(199,'Бампер Супер, КЭ','Прохлораз + пропиконазол 400 + 90 г/л',NULL,NULL),(200,'Банвел, ВР','Дикамба (диметиламинная соль) 480 г/л дикамбы к-ты','Адвокат, ВР;Альфа-Дикамба, ВРК;Санпэй, ВР;Витара, ВР;Герб-480, ВР ;Губернатор, ВР;Девиз, ВР;Декабрист, ВР;Дикамбел, ВР;Ларт, ВР;Мономакс, ВР;Мурал, ВР;Оптимум, ВРК;Дамба, ВР;Деймос, ВРК;Диамант, ВР;Дианат, ВР;Диастарт, ВР','2022-10-17 09:53:57'),(201,'Банджо Форте, КС','Флуазинам + диметоморф 200 + 200 г/л',NULL,'2022-10-17 09:53:57'),(202,'Бандур, КС','Аклонифен 600 г/л',NULL,'2022-10-17 09:53:57'),(203,'Банко, КС','Хлороталонил 500 г/л','Браво, КС;Грэмми, КС;Талант, СК','2022-10-17 09:53:57'),(205,'Баргузин, Г','Диазинон 100 г/кг',NULL,'2022-10-17 09:53:57'),(206,'Баритон Супер, КС','Протиоконазол + Тебуконазол + Флудиоксонил 50 + 10 + 37,5 г/л',NULL,'2022-10-17 09:53:57'),(207,'Баритон, КС','Протиоконазол + флуоксастробин 37,5 + 37,5 г/л',NULL,'2022-10-17 09:53:57'),(208,'Барон, ВР','Бентазон 480 г/л','АгроБазон, ВР;Альфа-бентазон, ВР;Базон, ВР;Базагран, BР;Бентазолин, ВР;Бентасил, ВР;Бентекс, ВР;Бентобел, ВР;Бентограм, ВР;Бентус, ВР;Бизон, ВК;Бонус, ВР;Бунт, ВР;Гарнизон, ВР;Гранбаз, ВР;Изобен, ВР;Корсар, ВРК;Наношанс, ВР;Ранголи-Базорон, ВР;Сикурс, ВР;Тигрис, ВР','2022-10-17 09:53:57'),(209,'Баста, ВР','Глюфосинат аммоний 150 г/л','Мегаполис, ВР','2022-10-17 09:53:57'),(210,'Батор, КС','Имидаклоприд + пенцикурон 140 + 150 г/л',NULL,'2022-10-17 09:53:57'),(211,'Батрайдер, СК','Альфа-циперметрин + имидаклоприд + клотианидин 125+100+50 г/л','Борей Нэо, СК;Жукоед, СК;Пиноцид, СК','2022-10-17 09:53:57'),(212,'Бегин Турбо, КС','Тербутилазин + С-Метолахлор 250 +250 г/л',NULL,'2022-10-17 09:53:57'),(213,'Бегин, КЭ','С-Метолахлор 960 г/л',NULL,'2022-10-17 09:53:57'),(214,'Беллис, ВДГ','Боскалид + пираклостробин 252 + 128 г/кг',NULL,'2022-10-17 09:53:57'),(215,'Белт, КС','Флубендиамид 480 г/л',NULL,'2022-10-17 09:53:57'),(216,'Бельведер Форте, СЭ','Этофумезат + фенмедифам + десмедифам 200 + 100 + 100 г/л',NULL,'2022-10-17 09:53:57'),(217,'Бельведер, СЭ','Десмедифам + фенмедифам 160 + 160 г/л','Агротех-Гарант-22, КЭ;Бетаниум 22, КЭ;Бетахим 22, КЭ ;Бетацвай, КЭ ;Беташанс Дабл, КЭ;Бетинол 22, КЭ ;Бифор 22, ВСК;Бифор 22, КЭ ;Вымпел 2, КЭ;Доцент, КЭ;Секира Дуэт, КС;Секунда, КЭ;Эксперт 22, КЭ;Эксперт Некст, КС;Бетанал 22, КЭ','2022-10-17 09:53:57'),(218,'Бен Гур, ВДГ','Трибенурон-метил 750 г/кг','Агростар, ВДГ;Альфа Стар, ВДГ;Аргамак, ВДГ;Аргамак, ВДГ-1001;Артстар, ВДГ;Бенрил, ВДГ;Гекстар, ВДГ;Герсотил, ВДГ;Герсотил, ВДГ+;Гран-при, ВДГ;Гранат, ВДГ;Гранд Плюс, ВДГ;Гранилин, ВДГ;Гренадер, ВДГ;Громстор, ВДГ;Грэнери, ВДГ;Гюрза, СП;Коррида, ВДГ;Мортира, ВДГ;Норман, ВДГ;Прометей, ВДГ;Ранголи-Трибенурон, ВДГ;Санфло, ВДГ;Спецназ 750, ВДГ;Сталкер, ВДГ;Старбокс, СТС;Суперстар, ВДГ;Таллер, ВДГ;Террастар, ВДГ;ТриАлт, ВДГ;Трибел, ВДГ;Трибинстар, ВДГ;Трибун, СТС;Трибунал, ВДГ;Тризлак, ВДГ;Триметил, ВДГ;Триммер, ВДГ;Ферат, ВДГ;Флюенс, ВДГ;Химстар, ВДГ;Шанстар, ВДГ;Экспресс, ВДГ','2022-10-17 09:53:57'),(219,'Беназол, СП','Беномил 500 г/кг','Беномил 500, СП;Бенорад, СП;Нор-Би, СП;Фундазол, СП','2022-10-17 09:53:57'),(220,'Беневия, МД','Циантранилипрол 100 г/л',NULL,'2022-10-17 09:53:57'),(221,'Бенефис, МЭ','Имазалил + металаксил + тебуконазол 50 + 40 + 30 г/л',NULL,'2022-10-17 09:53:57'),(222,'Бенито, ККР','Бентазон 300 г/л',NULL,'2022-10-17 09:53:57'),(223,'Беномил 500, СП','Беномил 500 г/кг','Беназол, СП;Бенорад, СП;Нор-Би, СП;Фундазол, СП','2022-10-17 09:53:57'),(224,'Бенорад, СП','Беномил 500 г/кг','Беномил 500, СП;Беназол, СП;Нор-Би, СП;Фундазол, СП','2022-10-17 09:53:57'),(225,'Бентазолин, ВР','Бентазон 480 г/л','АгроБазон, ВР;Альфа-бентазон, ВР;Базон, ВР;Барон, ВР;Базагран, BР;Бентасил, ВР;Бентекс, ВР;Бентобел, ВР;Бентограм, ВР;Бентус, ВР;Бизон, ВК;Бонус, ВР;Бунт, ВР;Гарнизон, ВР;Гранбаз, ВР;Изобен, ВР;Корсар, ВРК;Наношанс, ВР;Ранголи-Базорон, ВР;Сикурс, ВР;Тигрис, ВР','2022-10-17 09:53:57'),(226,'Бентасил, ВР','Бентазон 480 г/л','АгроБазон, ВР;Альфа-бентазон, ВР;Базон, ВР;Барон, ВР;Базагран, BР;Бентазолин, ВР;Бентекс, ВР;Бентобел, ВР;Бентограм, ВР;Бентус, ВР;Бизон, ВК;Бонус, ВР;Бунт, ВР;Гарнизон, ВР;Гранбаз, ВР;Изобен, ВР;Корсар, ВРК;Наношанс, ВР;Ранголи-Базорон, ВР;Сикурс, ВР;Тигрис, ВР','2022-10-17 09:53:57'),(227,'Бентобел, ВР','Бентазон 480 г/л','АгроБазон, ВР;Альфа-бентазон, ВР;Базон, ВР;Барон, ВР;Базагран, BР;Бентазолин, ВР;Бентасил, ВР;Бентекс, ВР;Бентограм, ВР;Бентус, ВР;Бизон, ВК;Бонус, ВР;Бунт, ВР;Гарнизон, ВР;Гранбаз, ВР;Изобен, ВР;Корсар, ВРК;Наношанс, ВР;Ранголи-Базорон, ВР;Сикурс, ВР;Тигрис, ВР','2022-10-17 09:53:57'),(228,'Бентограм, ВР','Бентазон 480 г/л','АгроБазон, ВР;Альфа-бентазон, ВР;Базон, ВР;Барон, ВР;Базагран, BР;Бентазолин, ВР;Бентасил, ВР;Бентекс, ВР;Бентус, ВР;Бизон, ВК;Бонус, ВР;Бунт, ВР;Гарнизон, ВР;Гранбаз, ВР;Изобен, ВР;Корсар, ВРК;Наношанс, ВР;Ранголи-Базорон, ВР;Сикурс, ВР;Тигрис, ВР','2022-10-17 09:53:57'),(229,'Бентус, ВР','Бентазон 480 г/л','АгроБазон, ВР;Альфа-бентазон, ВР;Базон, ВР;Барон, ВР;Базагран, BР;Бентазолин, ВР;Бентасил, ВР;Бентекс, ВР;Бизон, ВК;Бонус, ВР;Бунт, ВР;Гарнизон, ВР;Гранбаз, ВР;Изобен, ВР;Корсар, ВРК;Наношанс, ВР;Ранголи-Базорон, ВР;Сикурс, ВР;Тигрис, ВР','2022-10-17 09:53:57'),(230,