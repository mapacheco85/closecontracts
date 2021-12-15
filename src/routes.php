<?php

namespace PHPMaker2021\CloseContracts;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // contrato
    $app->any('/contratolist[/{CodContrato}]', ContratoController::class . ':list')->add(PermissionMiddleware::class)->setName('contratolist-contrato-list'); // list
    $app->any('/contratoadd[/{CodContrato}]', ContratoController::class . ':add')->add(PermissionMiddleware::class)->setName('contratoadd-contrato-add'); // add
    $app->any('/contratoview[/{CodContrato}]', ContratoController::class . ':view')->add(PermissionMiddleware::class)->setName('contratoview-contrato-view'); // view
    $app->any('/contratoedit[/{CodContrato}]', ContratoController::class . ':edit')->add(PermissionMiddleware::class)->setName('contratoedit-contrato-edit'); // edit
    $app->any('/contratodelete[/{CodContrato}]', ContratoController::class . ':delete')->add(PermissionMiddleware::class)->setName('contratodelete-contrato-delete'); // delete
    $app->group(
        '/contrato',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{CodContrato}]', ContratoController::class . ':list')->add(PermissionMiddleware::class)->setName('contrato/list-contrato-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{CodContrato}]', ContratoController::class . ':add')->add(PermissionMiddleware::class)->setName('contrato/add-contrato-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{CodContrato}]', ContratoController::class . ':view')->add(PermissionMiddleware::class)->setName('contrato/view-contrato-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{CodContrato}]', ContratoController::class . ':edit')->add(PermissionMiddleware::class)->setName('contrato/edit-contrato-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{CodContrato}]', ContratoController::class . ':delete')->add(PermissionMiddleware::class)->setName('contrato/delete-contrato-delete-2'); // delete
        }
    );

    // documento
    $app->any('/documentolist[/{CodDocumento}]', DocumentoController::class . ':list')->add(PermissionMiddleware::class)->setName('documentolist-documento-list'); // list
    $app->any('/documentoadd[/{CodDocumento}]', DocumentoController::class . ':add')->add(PermissionMiddleware::class)->setName('documentoadd-documento-add'); // add
    $app->any('/documentoview[/{CodDocumento}]', DocumentoController::class . ':view')->add(PermissionMiddleware::class)->setName('documentoview-documento-view'); // view
    $app->any('/documentoedit[/{CodDocumento}]', DocumentoController::class . ':edit')->add(PermissionMiddleware::class)->setName('documentoedit-documento-edit'); // edit
    $app->any('/documentodelete[/{CodDocumento}]', DocumentoController::class . ':delete')->add(PermissionMiddleware::class)->setName('documentodelete-documento-delete'); // delete
    $app->group(
        '/documento',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{CodDocumento}]', DocumentoController::class . ':list')->add(PermissionMiddleware::class)->setName('documento/list-documento-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{CodDocumento}]', DocumentoController::class . ':add')->add(PermissionMiddleware::class)->setName('documento/add-documento-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{CodDocumento}]', DocumentoController::class . ':view')->add(PermissionMiddleware::class)->setName('documento/view-documento-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{CodDocumento}]', DocumentoController::class . ':edit')->add(PermissionMiddleware::class)->setName('documento/edit-documento-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{CodDocumento}]', DocumentoController::class . ':delete')->add(PermissionMiddleware::class)->setName('documento/delete-documento-delete-2'); // delete
        }
    );

    // proveedor
    $app->any('/proveedorlist[/{CodProveedor}]', ProveedorController::class . ':list')->add(PermissionMiddleware::class)->setName('proveedorlist-proveedor-list'); // list
    $app->any('/proveedoradd[/{CodProveedor}]', ProveedorController::class . ':add')->add(PermissionMiddleware::class)->setName('proveedoradd-proveedor-add'); // add
    $app->any('/proveedorview[/{CodProveedor}]', ProveedorController::class . ':view')->add(PermissionMiddleware::class)->setName('proveedorview-proveedor-view'); // view
    $app->any('/proveedoredit[/{CodProveedor}]', ProveedorController::class . ':edit')->add(PermissionMiddleware::class)->setName('proveedoredit-proveedor-edit'); // edit
    $app->any('/proveedordelete[/{CodProveedor}]', ProveedorController::class . ':delete')->add(PermissionMiddleware::class)->setName('proveedordelete-proveedor-delete'); // delete
    $app->group(
        '/proveedor',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{CodProveedor}]', ProveedorController::class . ':list')->add(PermissionMiddleware::class)->setName('proveedor/list-proveedor-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{CodProveedor}]', ProveedorController::class . ':add')->add(PermissionMiddleware::class)->setName('proveedor/add-proveedor-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{CodProveedor}]', ProveedorController::class . ':view')->add(PermissionMiddleware::class)->setName('proveedor/view-proveedor-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{CodProveedor}]', ProveedorController::class . ':edit')->add(PermissionMiddleware::class)->setName('proveedor/edit-proveedor-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{CodProveedor}]', ProveedorController::class . ':delete')->add(PermissionMiddleware::class)->setName('proveedor/delete-proveedor-delete-2'); // delete
        }
    );

    // region
    $app->any('/regionlist[/{CodRegion}]', RegionController::class . ':list')->add(PermissionMiddleware::class)->setName('regionlist-region-list'); // list
    $app->any('/regionadd[/{CodRegion}]', RegionController::class . ':add')->add(PermissionMiddleware::class)->setName('regionadd-region-add'); // add
    $app->any('/regionview[/{CodRegion}]', RegionController::class . ':view')->add(PermissionMiddleware::class)->setName('regionview-region-view'); // view
    $app->any('/regionedit[/{CodRegion}]', RegionController::class . ':edit')->add(PermissionMiddleware::class)->setName('regionedit-region-edit'); // edit
    $app->any('/regiondelete[/{CodRegion}]', RegionController::class . ':delete')->add(PermissionMiddleware::class)->setName('regiondelete-region-delete'); // delete
    $app->group(
        '/region',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{CodRegion}]', RegionController::class . ':list')->add(PermissionMiddleware::class)->setName('region/list-region-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{CodRegion}]', RegionController::class . ':add')->add(PermissionMiddleware::class)->setName('region/add-region-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{CodRegion}]', RegionController::class . ':view')->add(PermissionMiddleware::class)->setName('region/view-region-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{CodRegion}]', RegionController::class . ':edit')->add(PermissionMiddleware::class)->setName('region/edit-region-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{CodRegion}]', RegionController::class . ':delete')->add(PermissionMiddleware::class)->setName('region/delete-region-delete-2'); // delete
        }
    );

    // servicio
    $app->any('/serviciolist[/{CodServicio}]', ServicioController::class . ':list')->add(PermissionMiddleware::class)->setName('serviciolist-servicio-list'); // list
    $app->any('/servicioadd[/{CodServicio}]', ServicioController::class . ':add')->add(PermissionMiddleware::class)->setName('servicioadd-servicio-add'); // add
    $app->any('/servicioview[/{CodServicio}]', ServicioController::class . ':view')->add(PermissionMiddleware::class)->setName('servicioview-servicio-view'); // view
    $app->any('/servicioedit[/{CodServicio}]', ServicioController::class . ':edit')->add(PermissionMiddleware::class)->setName('servicioedit-servicio-edit'); // edit
    $app->any('/serviciodelete[/{CodServicio}]', ServicioController::class . ':delete')->add(PermissionMiddleware::class)->setName('serviciodelete-servicio-delete'); // delete
    $app->group(
        '/servicio',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{CodServicio}]', ServicioController::class . ':list')->add(PermissionMiddleware::class)->setName('servicio/list-servicio-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{CodServicio}]', ServicioController::class . ':add')->add(PermissionMiddleware::class)->setName('servicio/add-servicio-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{CodServicio}]', ServicioController::class . ':view')->add(PermissionMiddleware::class)->setName('servicio/view-servicio-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{CodServicio}]', ServicioController::class . ':edit')->add(PermissionMiddleware::class)->setName('servicio/edit-servicio-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{CodServicio}]', ServicioController::class . ':delete')->add(PermissionMiddleware::class)->setName('servicio/delete-servicio-delete-2'); // delete
        }
    );

    // vencimientos
    $app->any('/vencimientoslist[/{CodContrato}]', VencimientosController::class . ':list')->add(PermissionMiddleware::class)->setName('vencimientoslist-vencimientos-list'); // list
    $app->group(
        '/vencimientos',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{CodContrato}]', VencimientosController::class . ':list')->add(PermissionMiddleware::class)->setName('vencimientos/list-vencimientos-list-2'); // list
        }
    );

    // resumen
    $app->any('/resumenlist', ResumenController::class . ':list')->add(PermissionMiddleware::class)->setName('resumenlist-resumen-list'); // list
    $app->group(
        '/resumen',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ResumenController::class . ':list')->add(PermissionMiddleware::class)->setName('resumen/list-resumen-list-2'); // list
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
