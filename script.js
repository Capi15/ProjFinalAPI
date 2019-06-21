$("#btnir").submit(clicar);
function clicar(e) {
    console.log("iuiuiu");
    e.preventDefault();
    //var busca = $("#estiloNavbar").val();
    var busca = $("input#estiloNavbar").val();
    console.log(busca);
    $.ajax({
        url: "https://www.flickr.com/services/rest/",
        data: {
            method: "flickr.photos.search",
            api_key: "dd9caf2bb711dcb364b85f99d10006bc",
            text: busca,
            extras: "url_m",
            per_page: "10",
            page: "1",
            format: "json",
            nojsoncallback: "1"
        },
        method: "GET",
        dataType: "JSON",
        success: function(infofotos) {
            console.log(infofotos);
            infofotos.photos.photo.forEach(foto => {
                var foto = $("<img>").attr("src", foto.url_m);
                $("#firstcontainer").append(foto);
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
                .append($("<p>").html("info para:" + infometeo.name))
                .append($("<p>").html(texto));
        }
    });
}
