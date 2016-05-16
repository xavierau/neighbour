/**
 * Created by Xavier on 16/5/2016.
 */

let actions = require('./../../vuex/actions');
let component = {
    vuex:{
        getters:{
            allMetrics:state=>state.metrics,
            shownMetrics:state=>state.shownMetrics
        },
        actions:{
            init:actions.getAllMetrics
        }
    },
    route:{
        data(transition){
            this.init(
                transition
            )
        }
    },
    template:require('./dashboard.html')
}

module.exports = component;