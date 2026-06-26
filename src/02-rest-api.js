const url = "http://roadmap.local/wp-json/wp/v2/posts";

async function getData() {

    const response = await fetch(url);
    const container = document.querySelector(".wpil-rest-api-section__container");
    const containerContent = container.innerHTML;

    if (!response.ok) {
        container.innerText = "Error con tu consulta!";
        return;
    }

    const requestedInfo = await response.json();

    container.innerHTML = "";

    requestedInfo.forEach((item) => {

        container.innerHTML += `
            <article class="wpil-rest-api-section__item">
                <a class="wpil-rest-api-section__item-title" href="${item.link}">
                    ${item.title.rendered}
                </a>
            </article>
        `;

    })

}

getData();
