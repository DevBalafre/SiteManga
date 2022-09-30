function toggleMenu () {  
  const navbar = document.querySelector('.navbar');
  const burger = document.querySelector('.burger');
  
  burger.addEventListener('click', (e) => {    
    navbar.classList.toggle('show-nav');
  });    
  // bonus
  const navbarLinks = document.querySelectorAll('.navbar a');
  navbarLinks.forEach(link => {
    link.addEventListener('click', (e) => {    
      navbar.classList.toggle('show-nav');
    }); 
  })
   
}
toggleMenu();


  const drop = document.querySelector (".drop") ;
  const btnDrop = document.querySelector (".bloc-top") ;
  let toggleIndex =0;

  btnDrop.addEventListener('click', (e) => {

  if(toggleIndex===0){
    drop.style.height = `${drop.scrollHeight}px`;
    toggleIndex++;

  }else{
    drop.style.height = `${btnDrop.scrollHeight}px`;
    toggleIndex--;
  }
})
