document.addEventListener('DOMContentLoaded', () => {

  const dropBtn = document.querySelector('.button-bar-delete');
  const dropItems = document.querySelector('.dropdown a');

  dropBtn.addEventListener('click',()=>{

    if (dropItems.style.display === 'none') {
      dropItems.style.display = 'block'
    } else {
      dropItems.style.display = 'none'
    }

  })

  // dropItems.forEach(item => {
  //   item.addEventListener('click', (e)=>{
  //     if (e.target.item.style.display === 'none') {
  //       item.style.display = 'block'
  //     } else {
  //       item.style.display = 'none'
  //     }
  //   })
  // })

});