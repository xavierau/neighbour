/**
 * Created by Xavier on 14/8/2016.
 */


export const updateUser = function(store, user){
    console.log("from actions");
    
    store.dispatch("UpdateUser", user)
}