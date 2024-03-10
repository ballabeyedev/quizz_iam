const cultureTitle = document.getElementById('culture-title');

function changeTextColor() {
  const randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
  
  cultureTitle.style.color = randomColor;
}

setInterval(changeTextColor, 2000);
