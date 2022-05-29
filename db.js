const mongoose = require('mongoose')

const DATABASE_NAME = 'pokemons'
const DATABASE_PORT = 27017

mongoose.connect(`mongodb://localhost:${DATABASE_PORT}/${DATABASE_NAME}`, {useMongoClient:true})

const db = mongoose.connection

module.exports = function() {
	return new Promise( (resolve, reject) => {
		db.on('error', () => reject(new Error(`Database Error : "${DATABASE_NAME}"`)))
		db.on('open', () => resolve(db))
    } )
}