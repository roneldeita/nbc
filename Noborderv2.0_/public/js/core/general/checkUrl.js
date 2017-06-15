
//noborderclub/role/projects/anythingWord
function urlForProjects () {
    var pathArray = window.location.pathname.split("/");
    if (pathArray[2] == "projects" && typeof pathArray[3] != "undefined" && pathArray[3] != "create" && pathArray[3] != "created"){
        return true;
    }
}

//noborderclub/role/projects/draft
function urlForDraft () {
    var pathArray = window.location.pathname.split("/");
    if (pathArray[2] == "projects" && pathArray[3] == "draft" ) {
        return true;
    }
}


//noborderclub/role/projects/published
function urlForPublished () {
    var pathArray = window.location.pathname.split("/");
    if (pathArray[2] == "projects" && pathArray[3] == "published" ) {
        return true;
    }
}

//noborderclub/role/projects/contract_signing
function urlForContract () {
    var pathArray = window.location.pathname.split("/");
    if (pathArray[2] == "projects" && pathArray[3] == "contract_signing" ) {
        return true;
    }
}



//noborderclub/role/projects/contract_signing
function urlForProgress () {
    var pathArray = window.location.pathname.split("/");
    if (pathArray[2] == "projects" && pathArray[3] == "in_progress" ) {
        return true;
    }
}

function urlForPrescreening () {
    var pathArray = window.location.pathname.split("/");
    if (pathArray[2] == "projects" && pathArray[3] == "pre_screening" ) {
        return true;
    }
}
