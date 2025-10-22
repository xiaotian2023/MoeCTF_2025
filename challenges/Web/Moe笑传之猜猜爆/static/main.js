let randomNumber = Math.floor(Math.random()*10000) + 1; // 1-10000
const guesses = document.querySelector('.guesses');
const lastResult = document.querySelector('.lastResult');
const lowOrHi = document.querySelector('.lowOrHi');
const guessBtn = document.getElementById('guessBtn');
const guessField = document.getElementById('guessField');

let guessCount = 1;
let resetButton;

function checkGuess() {
  let userGuess = Number(guessField.value);
  if(guessCount === 1) {
    guesses.textContent = '上次猜的数：';
  }
  guesses.textContent += userGuess + ' ';

  if(userGuess === randomNumber) {
    lastResult.textContent = '恭喜你！猜对了！';
    lastResult.style.backgroundColor = 'green';
    lowOrHi.textContent = '';
    guessField.disabled = true;
    guessBtn.disabled = true;
    // 猜对后请求flag
    fetch('/flag', {method: 'POST'})
      .then(res => res.json())
      .then(data => {
        document.querySelector('.flagResult').textContent = "FLAG: " + data.flag;
      });
    setGameOver();
  } else {
    lastResult.textContent = '!!!游戏结束!!!';
    lastResult.style.backgroundColor = 'red';
    if(userGuess < randomNumber) {
      lowOrHi.textContent = '你刚才猜低了！';
    } else if(userGuess > randomNumber) {
      lowOrHi.textContent = '你刚才猜高了！';
    }
    guessField.disabled = true;
    guessBtn.disabled = true;
    setGameOver();
  }

  guessCount++;
  guessField.value = '';
  guessField.focus();
}
guessBtn.addEventListener('click', checkGuess);

function setGameOver() {
  resetButton = document.createElement('button');
  resetButton.textContent = '开始新游戏';
  document.body.appendChild(resetButton);
  resetButton.addEventListener('click', resetGame);
}

function resetGame() {
  guessCount = 1;
  const resetParas = document.querySelectorAll('.resultParas p');
  for(let i = 0; i < resetParas.length; i++) {
    resetParas[i].textContent = '';
  }
  resetButton.parentNode.removeChild(resetButton);

  guessField.disabled = false;
  guessBtn.disabled = false;
  guessField.value = '';
  guessField.focus();

  lastResult.style.backgroundColor = 'white';

  randomNumber = Math.floor(Math.random()*10000) + 1; // 1-10000
}