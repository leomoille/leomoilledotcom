/*!
 * Start Bootstrap - Clean Blog v6.0.5 (https://startbootstrap.com/theme/clean-blog)
 * Copyright 2013-2021 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-clean-blog/blob/master/LICENSE)
 */
window.addEventListener('DOMContentLoaded', () => {
    let scrollPos = 0
    const mainNav = document.getElementById('mainNav')
    const headerHeight = mainNav.clientHeight

    window.addEventListener('scroll', function () {
        const currentTop = document.body.getBoundingClientRect().top * -1
        if (currentTop < scrollPos) {
          // Scrolling Up
            if (currentTop > 0 && mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-visible')
            } else {
                console.log(123)
                mainNav.classList.remove('is-visible', 'is-fixed')
            }
        } else {
          // Scrolling Down
            mainNav.classList.remove(['is-visible'])
            if (
            currentTop > headerHeight &&
            !mainNav.classList.contains('is-fixed')
            ) {
                mainNav.classList.add('is-fixed')
            }
        }
        scrollPos = currentTop
    })
})

function confirmDelete(id, name, type)
{
    let option = confirm(`Êtes - vous sur de vouloir supprimer "${name}"`)
    if (option) {
        alert(`"${name}" a bien été supprimé`)
        switch (type) {
            case 'post':
                document.location.href = ` / post / deletePost / ${id}`
            break
            case 'user':
                document.location.href = ` / users / deleteUser / ${id}`
            break
            default:
                document.location.href = ` / users / adminDashboard`
        }
    }
}
