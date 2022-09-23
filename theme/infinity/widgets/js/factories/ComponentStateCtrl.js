app.factory('ComponentStateCtrl',()=>{
    class ComponentStateCtrl {
        constructor(){
            this.states = {
                component:null
            }
        }
        exportStates(){
            return this.states;
        }
        onReady(callbackFn){
            this.states.component = 'onReady';
            callbackFn();
        }
        onLoad(callbackFn){
            this.states.component = 'onLoad';
            callbackFn();
        }
        onError(callbackFn){
            this.states.component = 'onError';
            callbackFn();
        }
    }
    return {
        create:()=>{
            return new ComponentStateCtrl();
        }
    }
});
