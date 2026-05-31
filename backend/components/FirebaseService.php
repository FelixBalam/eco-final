<?php
namespace backend\components;

use yii\base\Component;
use yii\helpers\Json;

class FirebaseService extends Component
{
    private $projectId = 'ecosort-2df8a'; 
    private $apiKey = 'AIzaSyBJrR1arl2p7dw3CRYJvkBNukSG3iHyUT0'; 
    private $databaseUrl;

    public function init()
    {
        parent::init();
        $this->databaseUrl = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/";
    }

    /**
     * LEER (GET) - Trae todos los registros de la colección ordenados por fecha desc
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
                    'timestamp' => $rawFecha ? strtotime($rawFecha) : 0 
                ];
            }
        }

        usort($resultado, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        return $resultado;
    }

    /**
     * CREAR (POST) - Inserta un nuevo reporte en Firestore
     */
    public function createReporte($contenedor, $nivel, $accion)
    {
        $url = $this->databaseUrl . "reportes_reciclaje?key=" . $this->apiKey;
        
        $dataObj = [
            'fields' => [
                'contenedor' => ['stringValue' => strval($contenedor)],
                'nivel' => ['integerValue' => intval($nivel)],
                'tipo_accion' => ['stringValue' => strval($accion)],
                'fecha' => ['timestampValue' => gmdate("Y-m-d\TH:i:s\Z")]
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

        if (!$response || strpos($response, '<!DOCTYPE html>') !== false) {
            return null;
        }

        return Json::decode($response);
    }

    /**
     * ACTUALIZAR (PATCH) - Modifica campos específicos de un documento usando updateMask
     */
    public function updateReporte($id, $contenedor, $nivel, $accion)
    {
        $url = $this->databaseUrl . "reportes_reciclaje/{$id}?updateMask.fieldPaths=contenedor&updateMask.fieldPaths=nivel&updateMask.fieldPaths=tipo_accion&key=" . $this->apiKey;
        
        $dataObj = [
            'fields' => [
                'contenedor' => ['stringValue' => strval($contenedor)],
                'nivel' => ['integerValue' => intval($nivel)],
                'tipo_accion' => ['stringValue' => strval($accion)]
            ]
        ];

        $payload = Json::encode($dataObj);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response || strpos($response, '<!DOCTYPE html>') !== false) {
            return null;
        }

        return Json::decode($response);
    }

    /**
     * BORRAR (DELETE) - Elimina físicamente un documento de la nube
     */
    public function deleteReporte($id)
    {
        $url = $this->databaseUrl . "reportes_reciclaje/{$id}?key=" . $this->apiKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return true;
    }
}