function showAside() {
    const aside = document.querySelector('.aside-content')
    const main = document.querySelector('main')

    aside.classList.toggle('show-aside')

    if (aside.classList.contains('show-aside')) {
        main.classList.add('col-md-10')
    }
    else {
        main.classList.remove('col-md-10')
    }

}