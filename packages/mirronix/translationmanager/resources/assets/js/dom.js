
const closest = (el, selector) => {
  let target = el;

  do {
    if (!target) break;
    if (target == document) break;

    if (target.matches(selector)) {
      return target;
    }

    target = target.parentNode;
  } while (true);

  return null;
}

export {
  closest,
}
