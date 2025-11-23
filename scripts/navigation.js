const hambi = document.querySelector('.hambi')
const backdrop = document.querySelector('.backdrop')
const body = document.querySelector('body');
const leaveNav = document.querySelector('.leave-nav');
const userMenu = document.querySelector('.user-menu')
const userDropdown = document.querySelector('.user-dropdown')


hambi.addEventListener('click',()=>{
    backdrop.style.display="flex"
    body.style.overflow = "hidden"
})
backdrop.addEventListener('click',(e)=>{
    if(e.target === backdrop){
        backdrop.style.display="none"
        body.style.overflow = "auto"
    }
})
leaveNav.addEventListener('click',(e)=>{
    backdrop.style.display="none"
    body.style.overflow = "auto"
}) 
userMenu.addEventListener('click', (e) => {
    userDropdown.classList.toggle('showDropdown')
})