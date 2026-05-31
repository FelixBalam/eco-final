<?php
namespace backend\components;

use yii\base\Component;
use yii\helpers\Json;

class FirebaseService extends Component
{
    private $projectId = 'ecosort-2df8a'; // Tu ID de proyecto de Firebase
    private $apiKey = 'AIzaSyBJrR1arl2p7dw3CRYJvkBNukSG3iHyUT0'; // Tu API Key de la app móvil
    private $databaseUrl;

    public function init()
    {
        parent::init();
        // Base de la URL para las peticiones REST de Firestore
        $this->databaseUrl = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/";
    }

    /**
     * Trae todos los registros de la colección ordenados del más nuevo al más viejo
     */
    public function getReportes()
    {
        $url = $this->databaseUrl . "reportes_reciclaje?key=" . $this->apiKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        // Si la respuesta falla o es un HTML de error de red, regresamos un arreglo vacío
        if (!$response || strpos($response, '<!DOCTYPE html>') !== false) {
            return [];
        }

        try {
            $data = Json::decode($response);
        } catch (\Exception $e) {
            return [];
        }
        
        $resultado = [];

        if (isset($data['documents'])) {
            foreach ($data['documents'] as $doc) {
                if (!isset($doc['fields'])) {
                    continue;
                }
                
                $fields = $doc['fields'];
                $idArray = explode('/', $doc['name']);
                
                $rawFecha = isset($fields['fecha']['timestampValue']) ? $fields['fecha']['timestampValue'] : null;
                $fechaFormateada = $rawFecha ? date('d/m/Y H:i:s', strtotime($rawFecha)) : 'Pendiente...';

                $resultado[] = [
                    'id' => end($idArray),
                    'contenedor' => isset($fields['contenedor']['stringValue']) ? $fields['contenedor']['stringValue'] : 'Otros',
                    'nivel' => isset($fields['nivel']['integerValue']) ? (int)$fields['nivel']['integerValue'] : (isset($fields['nivel']['doubleValue']) ? (int)$fields['nivel']['doubleValue'] : 0),
                    'tipo_accion' => isset($fields['tipo_accion']['stringValue']) ? $fields['tipo_accion']['stringValue'] : 'Lectura',
                    'fechaFormateada' => $fechaFormateada,
                    'timestamp' => $rawFecha ? strtotime($rawFecha) : 0 // Convertimos a número entero para ordenar con precisión
                ];
            }
        }

        // Ordenamos por timestamp numérico descendente (El número más grande / fecha más reciente arriba)
        usort($resultado, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        return $resultado;
    }

    /**
     * Inserta un nuevo reporte directo a Firestore autorizando con la API Key
     */
    public function createReporte($contenedor, $nivel, $accion)
    {
        // URL estructurada para la creación de documentos mediante la API REST de Firestore
        $url = $this->databaseUrl . "reportes_reciclaje?key=" . $this->apiKey;
        
        // Estructura JSON con el tipado estricto que requiere Google Cloud Firestore
        $dataObj = [
            'fields' => [
                'contenedor' => [
                    'stringValue' => strval($contenedor)
                ],
                'nivel' => [
                    'integerValue' => intval($nivel)
                ],
                'tipo_accion' => [
                    'stringValue' => strval($accion)
                ],
                'fecha' => [
                    'timestampValue' => gmdate("Y-m-d\TH:i:s\Z")
                ]
            ]
        ];

        $payload = Json::encode($dataObj);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        // Si la respuesta no existe o Firestore responde con una página HTML de error, retornamos null
        if (!$response || strpos($response, '<!DOCTYPE html>') !== false) {
            return null;
        }

        return Json::decode($response);
    }
}