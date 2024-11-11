const express = require('express');
const router = express.Router();
const clientController = require('../controllers/clientController');

/**
 * @swagger
 * /client/registerClient:
 *   post:
 *     summary: Registra un nuevo cliente
 *     tags: [Client]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               document:
 *                 type: string
 *               names:
 *                 type: string
 *               email:
 *                 type: string
 *               phone:
 *                 type: string
 *             required:
 *               - document
 *               - names
 *               - email
 *               - phone
 *     responses:
 *       200:
 *         description: Cliente registrado exitosamente
 *       400:
 *         description: Error en la solicitud
 */
router.post('/registerClient', clientController.registerClient);

module.exports = router;
