const popup = document.getElementById("pop");
const overlay = document.querySelector(".overlay");
const popup2 = document.getElementById("pop2");
const overlay2 = document.querySelector(".overlay2");
const popup3 = document.getElementById("pop3");
const overlay3 = document.querySelector(".overlay3");
const popup4 = document.getElementById("pop4");
const overlay4 = document.querySelector(".overlay4");


function closePopup(front, back) {
  front.style.display = "none";
  back.style.display = "none";
}

// Função para mudar o modo
function mudarModo(tipo) {
    // Armazena a escolha do usuário no localStorage
    localStorage.setItem('modoDaltonismo', tipo);
  
    // Remove todas as classes relacionadas ao modo daltonismo
    document.body.classList.remove('daltonismo', 'protanopia');
    document.documentElement.classList.remove('daltonismo', 'protanopia');
  
    // Adiciona a classe correspondente com base no tipo selecionado
    if (tipo === 'daltonismo') {
      document.body.classList.add('daltonismo');
      document.documentElement.classList.add('daltonismo');
    } else if (tipo === 'protanopia') {
      document.body.classList.add('protanopia');
      document.documentElement.classList.add('protanopia');
    } else {
      // Caso 'normal', remove qualquer filtro
      document.body.classList.remove('daltonismo', 'protanopia');
      document.documentElement.classList.remove('daltonismo', 'protanopia');
    }
  }
  
  // Ao carregar a página, aplica o modo armazenado no localStorage
  window.onload = function() {
    const modoSelecionado = localStorage.getItem('modoDaltonismo');
    if (modoSelecionado) {
      mudarModo(modoSelecionado);
    }
  };
  