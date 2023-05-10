import { format, parse } from 'date-fns';

const localeStrings = {
  datetime: {
    types: {
      full: '%d %f, %Y',
      full_time: '%F %d, %Y, %H:%i',
      short: '%d %f',
      month: '%F %Y',
    }
  }
}

const Lang = {
  get: (path) => path.split('.').reduce((acc, key) => acc[key], localeStrings),
  getLocale: () => 'ru',
}

const i18n = {
  ru: {
    months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
    monthsAcc: ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
  },
  en: {
    months: ['January', 'February', 'March', 'April','May', 'June', 'July', 'August', 'September', 'October','November', 'December'],
    monthsAcc: ['January', 'February', 'March', 'April','May', 'June', 'July', 'August', 'September', 'October','November', 'December'],
  }
}

const getMonthName = (month) => {
  return i18n['ru'].months[month - 1];
}

const getMonthAccName = (month) => {
  return i18n['ru'].monthsAcc[month - 1];
}

const getDateFromTimestamp = timestamp => {
  const cd = new Date();
  cd.setTime(timestamp * 1000);

  return format(cd, 'yyyy-MM-dd');
}

export const getDateTimeFromTimestamp = timestamp => {
  const cd = new Date();
  cd.setTime(timestamp * 1000);

  return format(cd, 'yyyy-MM-dd HH:mm:ss');
}

export const getTimestampFromDate = date => {
  return parse(date, 'yyyy-MM-dd HH:mm:ss', new Date());
}

const dateFormat = (type) => type.indexOf('%') === -1 ? Lang.get(`datetime.types.${type}`) : type;

const dateParsed = (type, params) => {
  const format = dateFormat(type);

  const date = typeof params === 'string' ? ((date) => {
    const dateString = date.toString().match(/[^0-9]/) ? date : getDateTimeFromTimestamp(date);
    const [ year, month, day, hour, minute, second ] =  dateString.split(/[^0-9]+/);
    return { year, month, day, hour, minute, second };
  })(params) : params;

  return format.replace(/%([a-zA-Z0-9]{1,2})/g, (m) => {
    switch (m[1]) {
      case 'd': return date.day;
      case 'D': return date.day;
      case 'F': return i18n[Lang.getLocale()]['months'][date.month - 1] || '';
      case 'f': return i18n[Lang.getLocale()]['monthsAcc'][date.month - 1] || '';
      case 'Y': return date.year;
      case 'H': return date.hour; // sprintf('%02d', $params['hour']);
      case 'h': return date.hour;
      case 'i': return date.minute;// sprintf('%02d', $params['minute']);
      default:
        return '';
    }
  });
}


const dateSpan = (from, to) => {
  if (!from) return '---';
  if (!to) {
    const [fromYear, fromMonth] = getDateFromTimestamp(from).split('-');
    const fromMonthName = getMonthAccName(fromMonth);
    return `с ${fromMonthName} ${fromYear}`;
  }

  const [fromYear, fromMonth] = getDateFromTimestamp(from).split('-');
  const [toYear, toMonth] = getDateFromTimestamp(to).split('-');

  const fromMonthName = getMonthName(fromMonth);
  const toMonthName = getMonthName(toMonth);

  if (fromYear === toYear) {
    if (fromMonth === toMonth) {
      // return `${toMonthName} ${toYear}`;
      return dateParsed('%F %Y', to);

    } else {
      // return `${fromMonthName} — ${toMonthName} ${toYear}`;
      return `${dateParsed('%F', from)} — ${dateParsed('%F %Y', to)}`;
    }

  } else {
    // return `${fromMonthName} ${fromYear} — ${toMonthName} ${toYear}`;
    return `${dateParsed('%F %Y', from)} — ${dateParsed('%F %Y', to)}`;
  }
}

const dateSpanDigits = (from, to) => {
  if (!from || !to) return '---';

  const [fromYear, fromMonth, fromDay] = getDateFromTimestamp(from).split('-');
  const [toYear, toMonth, toDay] = getDateFromTimestamp(from).split('-');

  if (fromYear == toYear && fromMonth == toMonth && fromDay == toDay) {
    return `${fromDay}.${fromMonth}.${fromYear}`;

  } else {
    return `${fromDay}.${fromMonth}.${fromYear} — ${toDay}.${toMonth}.${toYear}`;
  }
}


const dateVerbal = (date, options) => {
  if (!date) return false;
  if (date.length > 10) {
    date = date.substr(0, 10);
  }

  return dateParsed('full', date);
}

const verbalNumber = (sum, one, four, many, options= {}) => {
  const num = typeof sum === 'string' ? parseInt(sum) : sum;
  const checkSum = num % 100;
  const prefix = options.skipNumber ? '' : (options.separate ? separateDigits(num) : num) + ' ';

  if (checkSum <= 10 || checkSum >= 20) {
    switch (checkSum % 10) {
      case 1:
        return prefix + one;
      case 2:	case 3: case 4:
        return prefix + four;
    }
  }

  return prefix + many;
}

const innRegions = {
	items: [
  		{ id: '01', title: '01 Адыгея республика' },
        { id: '02', title: '02 Башкортостан республика' },
        { id: '03', title: '03 Бурятия республика' },
        { id: '04', title: '04 Алтай республика' },
        { id: '05', title: '05 Дагестан республика' },
        { id: '06', title: '06 Ингушетия республика' },
        { id: '07', title: '07 Кабардино-Балкарская республика' },
        { id: '08', title: '08 Калмыкия республика' },
        { id: '09', title: '09 Карачаево-Черкесская республика' },
        { id: '10', title: '10 Карелия республика' },
        { id: '11', title: '11 Коми республика' },
        { id: '12', title: '12 Марий Эл республика' },
        { id: '13', title: '13 Мордовия республика' },
        { id: '14', title: '14 Саха /Якутия/ республика' },
        { id: '15', title: '15 Северная Осетия - Алания республика' },
        { id: '16', title: '16 Татарстан республика' },
        { id: '17', title: '17 Тыва республика' },
        { id: '18', title: '18 Удмуртская республика' },
        { id: '19', title: '19 Хакасия республика' },
        { id: '20', title: '20 Чеченская республика' },
        { id: '21', title: '21 Чувашская Республика - Чувашия' },
        { id: '22', title: '22 Алтайский край' },
        { id: '23', title: '23 Краснодарский край' },
        { id: '24', title: '24 Красноярский край' },
        { id: '25', title: '25 Приморский край' },
        { id: '26', title: '26 Ставропольский край' },
        { id: '27', title: '27 Хабаровский край' },
        { id: '28', title: '28 Амурская область' },
        { id: '29', title: '29 Архангельская область' },
        { id: '30', title: '30 Астраханская область' },
        { id: '31', title: '31 Белгородская область' },
        { id: '32', title: '32 Брянская область' },
        { id: '33', title: '33 Владимирская область' },
        { id: '34', title: '34 Волгоградская область' },
        { id: '35', title: '35 Вологодская область' },
        { id: '36', title: '36 Воронежская область' },
        { id: '37', title: '37 Ивановская область' },
        { id: '38', title: '38 Иркутская область' },
        { id: '39', title: '39 Калининградская область' },
        { id: '40', title: '40 Калужская область' },
        { id: '41', title: '41 Камчатский край' },
        { id: '42', title: '42 Кемеровская область' },
        { id: '43', title: '43 Кировская область' },
        { id: '44', title: '44 Костромская область' },
        { id: '45', title: '45 Курганская область' },
        { id: '46', title: '46 Курская область' },
        { id: '47', title: '47 Ленинградская область' },
        { id: '48', title: '48 Липецкая область' },
        { id: '49', title: '49 Магаданская область' },
        { id: '50', title: '50 Московская область' },
        { id: '51', title: '51 Мурманская область' },
        { id: '52', title: '52 Нижегородская область' },
        { id: '53', title: '53 Новгородская область' },
        { id: '54', title: '54 Новосибирская область' },
        { id: '55', title: '55 Омская область' },
        { id: '56', title: '56 Оренбургская область' },
        { id: '57', title: '57 Орловская область' },
        { id: '58', title: '58 Пензенская область' },
        { id: '59', title: '59 Пермский край' },
        { id: '60', title: '60 Псковская область' },
        { id: '61', title: '61 Ростовская область' },
        { id: '62', title: '62 Рязанская область' },
        { id: '63', title: '63 Самарская область' },
        { id: '64', title: '64 Саратовская область' },
        { id: '65', title: '65 Сахалинская область' },
        { id: '66', title: '66 Свердловская область' },
        { id: '67', title: '67 Смоленская область' },
        { id: '68', title: '68 Тамбовская область' },
        { id: '69', title: '69 Тверская область' },
        { id: '70', title: '70 Томская область' },
        { id: '71', title: '71 Тульская область' },
        { id: '72', title: '72 Тюменская область' },
        { id: '73', title: '73 Ульяновская область' },
        { id: '74', title: '74 Челябинская область' },
        { id: '75', title: '75 Забайкальский край' },
        { id: '76', title: '76 Ярославская область' },
        { id: '77', title: '77 Москва город' },
        { id: '78', title: '78 Санкт-Петербург город' },
        { id: '79', title: '79 Еврейская автономная область' },
        { id: '83', title: '83 Ненецкий автономный округ' },
        { id: '86', title: '86 Ханты-Мансийский Автономный округ - Югра автономный округ' },
        { id: '87', title: '87 Чукотский автономный округ' },
        { id: '89', title: '89 Ямало-Ненецкий автономный округ' },
        { id: '91', title: '91 Крым республика' },
        { id: '92', title: '92 Севастополь город' },
        { id: '99', title: '99 Байконур город' },
	]
}

export {
  dateSpan,
  dateSpanDigits,
  dateVerbal,
  verbalNumber,
  dateParsed,
  dateFormat,
  innRegions,
}