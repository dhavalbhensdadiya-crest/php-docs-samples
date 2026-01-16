<?php
/*
 * Copyright 2025 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace Google\Cloud\Samples\SecretManager;

// [START secretmanager_create_regional_secret_with_topic]
use Google\Cloud\SecretManager\V1\CreateSecretRequest;
use Google\Cloud\SecretManager\V1\Secret;
use Google\Cloud\SecretManager\V1\Topic;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;

/**
 * Create a regional secret that uses a Pub/Sub topic for rotation notifications.
 *
 * @param string $projectId Google Cloud project id
 * @param string $locationId Secret location (e.g. 'us-central1')
 * @param string $secretId Id for the new secret
 * @param string $topicName Full Pub/Sub topic resource name (projects/{project}/topics/{topic})
 */
function create_regional_secret_with_topic(string $projectId, string $locationId, string $secretId, string $topicName): void
{
    $options = ['apiEndpoint' => "secretmanager.$locationId.rep.googleapis.com"];
    $client = new SecretManagerServiceClient($options);

    $parent = $client->locationName($projectId, $locationId);

    $secret = new Secret([
        'topics' => [new Topic(['name' => $topicName])],
    ]);

    $request = CreateSecretRequest::build($parent, $secretId, $secret);

    $created = $client->createSecret($request);

    printf('Created regional secret %s with topic %s' . PHP_EOL, $created->getName(), $topicName);
}
// [END secretmanager_create_regional_secret_with_topic]

require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
