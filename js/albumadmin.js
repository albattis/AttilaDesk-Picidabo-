"use strict"

const btnSave = document.querySelector('#ujszerzoModalSave');

btnSave.addEventListener('click',function(e){
    e.preventDefault();
    
    const urlapElem = document.querySelector("#ujszerzoModalForm")
    // console.log(urlapElem)
    let formData = new FormData(urlapElem)

    let kuldPromise = fetch(urlapElem.action,{
        method: "POST",
        body: formData
    })

    kuldPromise
        .then(response => response.json())
        .then(data => {
            if(data.success)
            {
                const dropdown = document.querySelector('#album_artist_id');

                let option = document.createElement("option")
                option.text = data.data.name
                option.value = data.data.id
                dropdown.appendChild(option)
                //dropdown.selectedaIndex = dropdown.options.length-1

                dropdown.value = data.data.id;
                $('#ujszerzoModal').modal('hide')
            }
            else {
                alert("Hiba!")
            }
        })

})