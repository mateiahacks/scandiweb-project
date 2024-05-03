<?php

namespace App\Controller;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use RuntimeException;
use Throwable;

use App\Types\SchemaTypes;
use App\Controller\CategoryController;

class GraphQL {
    static public function handle() {
        global $entity_manager;
        SchemaTypes::init();
        $category_controller = new CategoryController($entity_manager);

        try {
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'category' => [
                        'type'=> SchemaTypes::$category,
                        'args' => [
                            'title' => Type::string()
                        ],
                        'resolve' => fn($root, array $args) => $category_controller->get_category_by_name($args["title"]),
                    ],
                    'categories' => [
                        'type' => SchemaTypes::$categories,
                        'args' => [],
                        'resolve' => static fn() => $category_controller->get_all_categories(),
                    ]
                ],
            ]);
        
            $mutationType = new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'sum' => [
                        'type' => Type::int(),
                        'args' => [
                            'x' => ['type' => Type::int()],
                            'y' => ['type' => Type::int()],
                        ],
                        'resolve' => static fn ($calc, array $args): int => $args['x'] + $args['y'],
                    ],
                ],
            ]);
        
            // See docs on schema options:
            // https://webonyx.github.io/graphql-php/schema-definition/#configuration-options
            $schema = new Schema(
                (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
            );
        
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }
        
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
        
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();

        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }
        header('Access-Control-Allow-Origin: *');

        header('Access-Control-Allow-Methods: GET, POST');

        header("Access-Control-Allow-Headers: X-Requested-With");
        header('Content-Type: application/json; charset=UTF-8');

        return json_encode($output);
    }
}