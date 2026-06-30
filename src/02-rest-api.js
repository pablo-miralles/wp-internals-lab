const url = wpilPhpVariables.restUrl + "posts";

async function getData() {
    
    const container = document.querySelector(".wpil-rest-api-section__container");
    const containerContent = container.innerHTML;
    
    try {
        container.innerText = "Cargando...";
        const response = await fetch(url);
        const responseJson = await response.json();

        if (responseJson) {
            container.innerText = "";
            responseJson.forEach((item) => {
    
                container.innerHTML += `
                    <article class="wpil-rest-api-section__item">
                        <a class="wpil-rest-api-section__item-title" href="${item.link}">
                            ${item.title.rendered}
                        </a>
                    </article>
                `;
        
            })
        } else {
            container.innerText = "No posts available";
        }
        
    } catch(error) {
        console.log(error);
        container.innerText = "Error with your query";
    }

}

getData();
