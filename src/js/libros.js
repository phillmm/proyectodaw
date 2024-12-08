/*** VARIABLES GLOBALES ***/

// Función anónima autoejecutable

(function() {
    // Código a ejecutar
    let pagina = window.location.href;

    if (pagina.includes('libros/catalogo')) {
        catalogo();
    } else {
        return;
    }

    
    async function catalogo() {
        //Verificamos si hay filtro
        const url = new URL(window.location.href)
        const parametros = new URLSearchParams(url.search)

        let id = '0'
        if(parametros.has('id')) {
            id = parametros.get('id')
        }

        //Obtenemos los libros de la base de datos
        let libros = await getLibros(id)

        //Construimos los HTML
        construirCatalogo(libros)
    }

    /**
     * Función asíncrona que obtiene los libros del endpoint /api/libros,
     * puede filtrarlos por género si se le pasa un id como parámetro
     * @param {string} id id del género por el que se quiere filtrar
     * @returns Devuelve un array de objetos con los libros o un string con un mensaje de error
     */
    async function getLibros(id) {
        //Llamada a la API
        const url = '/api/libros'
        const respuesta = await fetch(url)
        const resultado = await respuesta.json()
        
        const tipo = respuesta.tipo
        let libros = resultado.libros

        //Revisamos si tenemos filtro, y filtramos en consecuencia
        if(id !== '0') {
            libros = libros.filter(libro => libro.id_genero === id)
        }

        if(tipo === 'error') {
            return resultado.mensaje //string
        } else {
            return libros //object
        }
    }

    function construirCatalogo(libros) {
        //Seleccionamos el elemento contenedor del catálofo
        const catalogo = document.querySelector('#catalogo')

        //Iteramos sobre los libros
        for(let libro of libros) {
            const enlace = document.createElement('A') //Enlace contenedor de la tarjeta
            enlace.href = '/libro/ficha?id=' + libro.id_libro //Enlace a la página de detalle

            //Construimos la tarjeta
            const tarjeta = document.createElement('DIV')
            tarjeta.classList.add('catalogo__tarjeta')

            //Imagen de la tarjta -> en esta primera versión del proyecto se trabajará con las imágenes por defecto
            const imagen = document.createElement('IMG')
            imagen.src = '/build/img/default.jpeg'
            imagen.alt = libro.titulo

            //Contenido de la tarjeta
            const contenido = document.createElement('DIV')
            contenido.classList.add('catalogo__tarjeta--texto')

            const nombre = document.createElement('H4') //Título del libro
            nombre.classList.add('catalogo__tarjeta--titulo')
            nombre.textContent = libro.nombre

            const autor = document.createElement('P')   //Autor del libro
            autor.classList.add('catalogo__tarjeta--autor')
            autor.textContent = libro.autor

            const genero = document.createElement('P')  //Género del libro
            genero.classList.add('catalogo__tarjeta--genero')
            genero.textContent = libro.nombre_genero

            const precio = document.createElement('P')  //Precio del libro
            precio.classList.add('catalogo__tarjeta--precio')
            precio.textContent = libro.precio + ' €'

            contenido.appendChild(nombre)
            contenido.appendChild(autor)
            contenido.appendChild(genero)
            contenido.appendChild(precio)

            //Agreamos el contenido a la tarjeta
            tarjeta.appendChild(imagen)
            tarjeta.appendChild(contenido)

            //Agregamos la tarjeta al enlace
            enlace.appendChild(tarjeta)

            //Agregamos el enlace al catálogo
            catalogo.appendChild(enlace)
        }

    }
})();
