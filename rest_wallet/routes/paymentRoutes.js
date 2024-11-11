const express = require('express');
const router = express.Router();
const paymentController = require('../controllers/paymentController');

/**
 * @swagger
 * /payment/pay:
 *   post:
 *     summary: Realizar un pago
 *     tags: [Pay]
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
 *               product:
 *                 type: string
 *             required:
 *               - document
 *               - phone
 *               - amount
 *               - product
 *     responses:
 *       200:
 *         description: Pago realizado con éxito
 *       400:
 *         description: Error en la solicitud
 */
router.post('/pay', paymentController.pay);

/**
 * @swagger
 * /payment/confirm-payment:
 *   post:
 *     summary: Confirmar un pago
 *     tags: [Pay]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               token:
 *                 type: number
 *             required:
 *               - token
 *     responses:
 *       200:
 *         description: Pago confirmado con éxito
 *       400:
 *         description: Error en la solicitud
 */
router.post('/confirm-payment', paymentController.confirmPayment);

module.exports = router;
