const postText = document.getElementById("post-text");
const imageUpload = document.getElementById("image-upload");
const postButton = document.getElementById("post-button");
const postsContainer = document.getElementById("posts-c");

const reactions = document.querySelectorAll(".iconst i");
var selectedReactions = [];

function resetReactionColors() {
  reactions.forEach((reaction) => {
    reaction.style.color = "black";
  });
  selectedReactions = [];
}

reactions.forEach((reaction) => {
  reaction.addEventListener("click", () => {
    

    const reactionClass = reaction.classList[1]; // Get the icon class

    // Check if the clicked icon is already selected
    const isSelected = selectedReactions.includes(reactionClass);

    // Toggle color based on selection state
    reaction.style.color = isSelected ? "black" : "red";

    // Update selectedReactions array
    if (isSelected) {
      selectedReactions.splice(selectedReactions.indexOf(reactionClass), 1);
    } else {
      selectedReactions.push(reactionClass);
    }
  });
});

postButton.addEventListener("click", () => {
  const postContent = postText.value;


  const newPost = document.createElement("div");
  newPost.classList.add("post");
  
  const tenis = false
  

  newPost.innerHTML = `
            <div class="head_post">
            <div class="icon_post">
              <img src="img/adan.png" alt="taldo adan" />
            </div>
             <div class="txt_post">
              <h1>User@129839012</h1>
              <p>12/02/2024 | 15:15 
              <p id="sacu"></p>
            </p>
            <script>
                const pendente = true;
                const status = document.getElementById("sacu")
                if (pendente==true){
                    status.textContent = "pendente"
                }else{
                    status.textContent = "concluído"
                }
          </script>
              <div id="edit"class="edit">
                <button class="butti">
                    Deletar <i class="bi bi-trash"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="body_post">
            <div class="txtBody">
              <h1>${postContent}</h1>
            </div>
            <div class="imgBody">
               <img src="${imageUrl}" alt="">
            </div>
          </div>
          <div class="footer_post">
            <div class="likes_post">
              <i id="cool" class="bi bi-hand-thumbs-up-fill"></i>
              <i id="cool" class="bi bi-hand-thumbs-down-fill"></i>
            </div>
           <div class="coment_post">
              <a href="/comment"><i id="cool" class="bi bi-chat-dots-fill"></i></a>
            </div>
            <div class="tags_post">
                ${selectedReactions
                  .map((reaction) => `<i class="bi ${reaction}"></i>`)
                  .join("")}
                </div>
          </div>
            `;
  postsContainer.appendChild(newPost);



  // Limpar os campos e o array de reações após o post
  postText.value = "";
  imageUpload.value = "";
  selectedReactions = [];
  resetReactionColors();
});
