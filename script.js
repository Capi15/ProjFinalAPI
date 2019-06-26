$("#btnir").submit(clicar);

function clicar(e) {
    var fotos;
    var noticias;

    /*console.log("iuiuiu");*/
    e.preventDefault();
    //var busca = $("#estiloNavbar").val();
    var busca = $("input#estiloNavbar").val();
    console.log(busca);
    $("#sec").html("");
    $.ajax({
        url: "http://api.openweathermap.org/data/2.5/weather",
        data: {
            q: busca,
            appid: "9a7d023c298da7e4d3b4366b1f12c5dc",
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
                infometeo.main.temp +
                "ºC";
            $("#sec")
                .append(
                    $("<p>").html(
                        "<h1>Pesquisa para " + infometeo.name + ":</h1>"
                    )
                )
                .append(
                    $("<p>").html(
                        `<h3>${texto.charAt(0).toUpperCase()}${texto.slice(
                            1
                        )}</h3>`
                    )
                );
        }
    });

    $.ajax({
        url: "https://www.flickr.com/services/rest/",
        data: {
            method: "flickr.photos.search",
            api_key: "dd9caf2bb711dcb364b85f99d10006bc",
            text: busca,
            extras: "url_m",
            per_page: "12",
            page: "1",
            format: "json",
            nojsoncallback: "1"
        },

        method: "GET",
        dataType: "JSON",
        success: function(infofotos) {
            console.log(infofotos);

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
                    noticias = infonews;

                    infonews.articles.forEach((ele, i) => {
                        cardP(
                            infofotos.photos.photo[
                                Math.floor(
                                    Math.random() *
                                        infofotos.photos.photo.length
                                )
                            ],
                            ele,
                            i
                        );
                    });
                }
            });
            console.log(fotos);
            console.log(noticias);

            function cardP(fotos, noticias, i) {
                if (i % 6 === 0) {
                    $("#sec").append(`<div class="row p-3"></div>`);
                }
                $("#sec")
                    .children(".row")
                    .last()
                    .append(
                        `<div class="col-lg-2 col-md-3 col-sm-4">
                            <div class="card" style="height: 100%;">
                                <img class="card-img-top image-fluid" src="${
                                    fotos.url_m
                                }">
                                <div class="card-body">
                                    <h5 class="card-title">${
                                        noticias.title
                                    }</h5>
                                    <p class="card-text">${
                                        noticias.description
                                    }</p>
                                </div>
                            </div>
                        </div>`
                    );
            }
        }
    });
}
