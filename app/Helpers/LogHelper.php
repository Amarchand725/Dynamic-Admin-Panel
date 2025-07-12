<?php

use App\Observers\ModelLogObserver;

function logAction($record, $action){
    // Manually trigger the observer's `show` method
    $observer = new ModelLogObserver();
    $observer->log_action($record, $action);
}
function logShowRecord($record){
    // Manually trigger the observer's `show` method
    $observer = new ModelLogObserver();
    $observer->show($record);
}

function logShowColumn($record, $column){
    // Trigger the observer for a specific column
    $observer = new ModelLogObserver();
    $observer->showColumn($record, $column); // Replace with your column name
}
function logDownloadDocument($record, $column){
    // Trigger the observer for a specific column
    $observer = new ModelLogObserver();
    $observer->downloadedDocument($record, $column); // Replace with your column name
}

function restoreRecord($record){
    $observer = new ModelLogObserver();
    $observer->restoreRecord($record); // Replace with your column name
}

function actionLabel($action){
    if($action=='create'){
        return '<span class="badge bg-label-success me-1">Create</span>';
    }elseif($action=='update'){
        return '<span class="badge bg-label-primary me-1">Update</span>';
    }elseif($action=='delete'){
        return '<span class="badge bg-label-danger me-1">Delete</span>';
    }elseif($action=='show'){
        return '<span class="badge bg-label-info me-1">Show</span>';
    }elseif($action=='show_column'){
        return '<span class="badge bg-label-warning me-1">Show Column</span>';
    }elseif($action=='downloaded-document'){
        return '<span class="badge bg-label-dark me-1">Downloaded Document</span>';
    }else{
        return '<span class="badge bg-label-secondary me-1">Unknown</span>';
    }
}