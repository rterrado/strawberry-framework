app.service('RouteSvc',()=>{

    const urlParser=()=>{
        urlParts = window.location.href.split('/');
        return {
            protocol: urlParts[0],
            domain: urlParts[2],
            page: urlParts[4] ?? 'dashboard'
        }
    }

    const makeUrl=(uriObj)=>{
        return uriObj.protocol+'//'+uriObj.domain+'/#/'+uriObj.page;
    }

    return {
        set:(page)=>{
            let uris = urlParser();
            let newUrl = makeUrl({protocol:uris.protocol,domain:uris.domain,page:page});
            window.location.href = newUrl;
        },
        getPage:()=>{
            let uris = urlParser();
            return uris.page;
        }
    }
});
