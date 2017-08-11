<?php

namespace browner12\percy;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Percy
{
    /**
     * @var string
     */
    private $apiUrl = 'https://percy.io/api/v1/';

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $project;

    /**
     * @var array
     */
    private $widths = [575, 767, 991, 1199, 1200];

    /**
     * constructor
     *
     * @param string $token
     * @param null   $project
     */
    public function __construct($token, $project)
    {
        //assign
        $this->token = $token;
        $this->project = $project;

        //guzzle client
        $this->client = new Client(['base_uri' => $this->apiUrl]);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [
            'User-Agent'    => 'Percy Bot',
            'Authorization' => 'Token token=' . $this->token,
            'Content-Type'  => 'application/vnd.api+json',
        ];
    }

    /**
     * @param array $snapshots
     */
    public function snapshot(array $snapshots)
    {
        try {

            //start the build
            $build = $this->createBuild($this->project);

            //loop through snapshots
            foreach ($snapshots as $name => $snapshot) {

                //create snapshot
                $snapshotResponse = $this->createSnapshot($build, $name, $snapshot);

                dd($snapshotResponse);

                //loop through pages
                foreach ($snapshot as $asset) {

                    //upload the asset
                    $this->uploadAsset($build, $asset);
                }

                //finalize snapshot
                $this->finalizeSnapshot($snapshotResponse);
            }

            $this->finalizeBuild($build);
        }

            //guzzle exception
        catch (ClientException $e) {

            dd($e->getResponse()->getBody()->getContents());
        }

            //exception
        catch (Exception $e) {

            dd($e);
        }
    }

    /**
     * @param \App\Percy\Build $build
     * @param \App\Percy\Asset $asset
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function uploadAsset(Build $build, Asset $asset)
    {
        $data = [
            'data' => [
                'type'       => 'resources',
                'id'         => $asset->hash,
                'attributes' => [
                    'base64-content' => $asset->encoding,
                ],
            ],
        ];

        $response = $this->client->post('builds/' . $build->id . '/resources/', [
            'headers'                 => $this->getHeaders(),
            'json'                    => $data,
            'resolveWithFullResponse' => true,
            'debug'                   => false,
        ]);

        return $response;
    }

    /**
     * @param string $repository
     * @param array  $options
     * @return \App\Percy\Build
     * @throws \App\Percy\PercyException
     */
    public function createBuild($repository, $options = null)
    {
        //setup data
        $data = [
            'data' => [
                'type'          => 'builds',
                'attributes'    => [
                    'branch'              => 'master',
                    'target-branch'       => 'master',
                    'commit-sha'          => hash('sha1', rand()),
                    'pull-request-number' => '1',
                ],
                'relationships' => [
                    'resources' => [
                        'data' => [],
                    ],
                ],
            ],
        ];

        //send request
        $response = $this->client->post('repos/' . $repository . '/builds/', [
            'headers'                 => $this->getHeaders(),
            'json'                    => $data,
            'resolveWithFullResponse' => true,
            'debug'                   => false,
        ]);

        //throw exception for bad responses
        /*if ($response->getStatusCode() != 200) {
            throw new PercyException();
        }*/

        //return a build
        return new Build(json_decode($response->getBody()));
    }

    /**
     * @param \App\Percy\Build $build
     * @param string           $name
     * @param array            $assets
     * @param array            $options
     * @return \App\Percy\Snapshot
     */
    public function createSnapshot(Build $build, $name, array $assets, $options = null)
    {
        //setup data
        $data = [
            'data' => [
                'type'          => 'snapshots',
                'attributes'    => [
                    'name'              => $name,
                    'enable-javascript' => false,
                    'widths'            => $this->widths,
                    'minimum-height'    => 500,
                ],
                'relationships' => [
                    'resources' => [
                        'data' => null,
                    ],
                ],
            ],
        ];

        //setup relationships
        foreach ($assets as $asset) {
            $data['data']['relationships']['resources']['data'][] = $asset->serialize();
        }

        //send request
        $response = $this->client->post('builds/' . $build->id . '/snapshots/', [
            'headers'                 => $this->getHeaders(),
            'json'                    => $data,
            'resolveWithFullResponse' => true,
            'debug'                   => false,
        ]);

        //throw exception for bad responses
        /*if ($response->getStatusCode() != 200) {
            throw new PercyException();
        }*/

        //return a snapshot
        return new Snapshot(json_decode($response->getBody()));
    }

    /**
     * @param \App\Percy\Snapshot $snapshot
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function finalizeSnapshot(Snapshot $snapshot)
    {
        $response = $this->client->post('snapshots/' . $snapshot->id . '/finalize', [
            'headers'                 => $this->getHeaders(),
            'resolveWithFullResponse' => true,
            'debug'                   => false,
        ]);

        return $response;
    }

    /**
     * @param \App\Percy\Build $build
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function finalizeBuild(Build $build)
    {
        $response = $this->client->post('builds/' . $build->id . '/finalize', [
            'headers'                 => $this->getHeaders(),
            'resolveWithFullResponse' => true,
            'debug'                   => false,
        ]);

        return $response;
    }
}
