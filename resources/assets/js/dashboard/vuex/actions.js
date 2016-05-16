/**
 * Created by Xavier on 16/5/2016.
 */

const increment = ({dispatch})=>dispatch('INCREMENT');
const getAllMetrics = function({dispatch}){
    return this.$http.get('api/metrics').then(response=>{
        dispatch("UPDATEMETRICS",response.data.metrics )
        dispatch("UPDATESHOWNMETRICS",response.data.shownMetrics )
    });
};

module.exports = {
    increment,
    getAllMetrics
};