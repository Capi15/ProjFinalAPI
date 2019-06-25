$("#btnir").submit(clicar);

function clicar(e) {
    /*console.log("iuiuiu");*/
    e.preventDefault();
    //var busca = $("#estiloNavbar").val();
    var busca = $("input#estiloNavbar").val();
    console.log(busca);
    $("#firstcontainer").html("");
    $.ajax({
        url: "https://www.flickr.com/services/rest/",
        data: {
            method: "flickr.photos.search",
            api_key: "dd9caf2bb711dcb364b85f99d10006bc",
            text: busca,
            extras: "url_m",
            per_page: "5",
            page: "1",
            format: "json",
            nojsoncallback: "1"
        },

        method: "GET",
        dataType: "JSON",
        success: function(infofotos) {
            console.log(infofotos);
            infofotos.photos.photo.forEach((foto, i) => {
                if (i % 4 === 0) {
                    $("#firstcontainer").append(`<div class="row p-3"></div>`);
                }

                $("#firstcontainer")
                    .children(".row")
                    .last().append(`
                    <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card" >
                        <img class="card-img-top image-fluid" style="heigth: auto" src="${
                            foto.url_m
                        }">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                    </div>
                `);
            });
        }
    });

    $.ajax({
        url: "http://api.openweathermap.org/data/2.5/weather",
        data: {
            q: busca,
            appid: "fa454439b36b644d49e751a9b0afbcfc",
            units: "metric",
            lang: "pt"
        },
        method: "GET",
        dataType: "JSON",
        success: function(infometeo) {
            console.log(infometeo);
            var texto =
                infometeo.weather[0].description +
                " a temperatura atual é: " +
                infometeo.main.temp;
            $("#firstcontainer")
                .append($("<p>").html("Pesquisa para " + infometeo.name + ":"))
                .append($("<p>").html(texto));
        }
    });

    $.ajax({
        url: "https://newsapi.org/v2/everything",
        data: {
            q: busca,
            apiKey: "3ea173618fa64bafa48290c8882e39d9",
            sortBy: "popularity",
            from: "2019-06-22"
        },
        method: "GET",
        dataType: "JSON",
        success: function(infonews) {
            console.log(infonews);
            for (let i = 0; i <= infonews.articles.lenght; i++) {
                var text = infonews.articles[i];
                $("#firstcontainer").append(
                    $("<p>")
                        .html(text)
                        .val()
                );
            }
        }
    });
}
