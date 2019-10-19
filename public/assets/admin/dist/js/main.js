const xhr = new XMLHttpRequest();


/**
 * suppression en ajax
 */
function ajaxDelete() {
    let deleteForms = document.querySelectorAll('#delete');
    if (deleteForms) {
      for (let i = 0; i < deleteForms.length; i++) {
        deleteForms[i].addEventListener('submit', function (e) {
          e.preventDefault();
          let response = window.confirm('Voulez-vous vraiment Supprimer ?');
          if (response) {
            let data = (new FormData(this));
            let deleteBtn = this.querySelector('button');
            let nativeContent = deleteBtn.innerHTML;
            deleteBtn.innerHTML = "Chargement...";

            xhr.open('POST', this.getAttribute('action'), true);
            xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
            xhr.onreadystatechange = () => {
              if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                  let $th = $(this).parent().parent().parent();
                  $th.fadeOut();
                } else {
                  console.log(xhr.responseText);
                  deleteBtn.innerHTML = nativeContent;
                  alert('Une erreur est survenue');
                }
              }
            };
            try {
              xhr.send(data);
            } catch (e) {
              if (e.NETWORK_ERR) {
                alert('Aucune connexion internet');
              } else if (e.ABORT_ERR) {
                alert("La suppression a ete annule");
              }
            }
            xhr.timeout = 10000;
          } else {
            return false;
          }
        })
      }
    }
}


/**
 * affiche les images
 */
function showTableImage() {
    let trigger = document.querySelector("#show-table-images");
    if (trigger) {
      let images = [].slice.call(document.querySelectorAll('img[data-src]'));
      trigger.addEventListener('click', () => {
        if (images) {
          images.forEach(image => {
            let dataSrc = image.getAttribute('data-src');
            let src = image.getAttribute('src');
            if (dataSrc) {
              image.removeAttribute('data-src');
              image.setAttribute('src', dataSrc);
            } else if (src) {
              image.removeAttribute('src');
              image.setAttribute('data-src', src);
            }
          });
        } else {
          alert('aucune image a afficher');
        }
      });
    }
}


/**
 * affiche une image avant l'upload
 * @param element
 */
function showImageBeforeUpload(element) {
    let form = document.querySelector(element);
    if (form) {
        let input = form.querySelector("input[type='file']");
        let showContainer = document.querySelector("[data-action='show-uploaded-file']");
        let admitExt = ['jpg', 'jpeg', 'png', 'gif'];
        let adminTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

        let getFile = function(files) {
            let reader = new FileReader();
            reader.readAsDataURL(files);
            reader.addEventListener('load', function() {
                let tag = document.createElement('img');
                tag.classList.add('responsive-img');
                tag.setAttribute('width', '70%');
                tag.setAttribute('height', 'auto');
                tag.src = this.result;
                showContainer.innerHTML = "";
                showContainer.appendChild(tag);

                let label = document.querySelector("label[for='thumb']");
                label.innerText = "Photo de couverture choisie";
            });
        };

        input.addEventListener('change', function() {
            let file = this.files[0];
            let ext = file.name.substr(file.name.lastIndexOf('.') + 1).toLowerCase();
            let type = file.type;

            if (admitExt.includes(ext, 0) && adminTypes.includes(type, 0)) {
                if (file.size <= 15728640) {
                    getFile(file);
                } else {
                    alert('Votre image est trop grande, 15mb maximum');
                }
            } else {
                alert('Veuillez choisiz une image svp !');
            }
        });
    }
}
