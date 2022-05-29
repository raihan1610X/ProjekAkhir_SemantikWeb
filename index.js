const path    = require('path')
const express = require('express')
const app     = express()

const Pokemon = require('./Pokemon.model')


app.set('view engine', 'pug')
app.set('views', path.resolve('views'))
app.set('port', 3000)

app.use(express.static(path.resolve('static')))
app.use(express.static(path.resolve('public')))

app.get('/', (request, response) => {

    Pokemon.find({}).lean().exec().then(pokemonsList => 
        response.render('index', {pokemonsList})
    );

});

const connectToDatabase = require('./db');

connectToDatabase().then(() => {
    console.info('Terhubung ke Databse')
    app.listen(app.get('port'), () => console.info(`Server Terhubung ke Port : ${app.get('port')}`))
}).catch(console.error)