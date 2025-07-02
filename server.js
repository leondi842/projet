const express = require('express');
const bodyParser = require('body-parser');
const { MessagingResponse } = require('twilio').twiml;
require('dotenv').config();

const app = express();
app.use(bodyParser.urlencoded({ extended: false }));

app.post('/webhook', (req, res) => {
    const twiml = new MessagingResponse();
    const msg = req.body.Body.toLowerCase();

    let response;

    if (msg.includes("bonjour") || msg.includes("salut")) {
        response = "👋 Bonjour ! Que puis-je faire pour vous ? (ex: réserver, prix, contact)";
    } else if (msg.includes("réserver")) {
        response = "Super ! Envoyez-moi votre nom, date d’arrivée, de départ et statut (invité/intervenant).";
    } else if (msg.includes("prix")) {
        response = "💸 Les intervenants paient 7500 FCFA/nuit. Professeurs invités = gratuit.";
    } else if (msg.includes("chambre")) {
        response = "🛏️ Toutes les chambres sont climatisées avec Wi-Fi. Précisez vos dates pour la dispo.";
    } else if (msg.includes("contact") || msg.includes("aide")) {
        response = "📞 Contact : support@unz.bf ou +226 XX XX XX XX.";
    } else {
        response = "🤖 Je ne comprends pas. Essayez : réserver, prix, chambre, contact.";
    }

    twiml.message(response);
    res.type('text/xml').send(twiml.toString());
});

app.listen(3000, () => {
    console.log('✅ Bot WhatsApp en ligne sur http://localhost:3000');
});
