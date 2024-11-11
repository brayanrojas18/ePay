const express = require('express');
const router = express.Router();
const walletController = require('../controllers/walletController');

/**
 * @swagger
 * /wallet/recharge-wallet:
 *   post:
 *     summary: Confirmar un pago
 *     tags: [Wallet]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               document:
 *                 type: string
 *               phone:
 *                 type: string
 *               amount:
 *                 type: number
 *             required:
 *               - document
 *               - phone
 *               - amount
 *     responses:
 *       200:
 *         description: Recarga realizada con éxito
 *       400:
 *         description: Error en la solicitud
 */
router.post('/recharge-wallet', walletController.rechargeWallet);

/**
 * @swagger
 * /wallet/check-balance:
 *   get:
 *     summary: Confirmar un pago
 *     tags: [Wallet]
 *     parameters:
 *       - in: query
 *         name: document
 *         schema:
 *           type: string
 *         required: true
 *         description: Documento
 *       - in: query
 *         name: phone
 *         schema:
 *           type: string
 *         required: true
 *         description: Teléfono
 *     responses:
 *       200:
 *         description: Saldo consultado con éxito
 *       400:
 *         description: Solicitud inválida
 */
router.get('/check-balance', walletController.checkBalance);

module.exports = router;
