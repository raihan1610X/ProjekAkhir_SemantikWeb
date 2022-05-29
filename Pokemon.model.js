const mongoose = require('mongoose')

mongoose.Promise = global.Promise

const ObjectId = mongoose.Schema.Types.ObjectId;

const contactSchema = mongoose.Schema({
	'_id'            : {type: ObjectId, required: true, index: true, auto: true},
	'id'             : {type: Number, required  : true},
	'name'           : {type: Number, required  : true},
	'type'         	 : {type: Number, required  : true},
	'region'         : {type: Number, required  : true},
	'game'           : {type: Number, required  : true},
	'generation'     : {type: Number, required  : true}
	
}, {collection : 'pokemonsList'}) 

module.exports = mongoose.model('Pokemon', contactSchema)