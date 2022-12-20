import React from "react";
// import ReactDom from "react-dom";
import { createRoot } from 'react-dom/client'
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import Login from './Auth/Login';
import { useState } from "react";
import { useSelector } from "react-redux";
export const BASE_URL = 'http://127.0.0.1:8000';

export default function App(){
    return(
        <div className="App">
        <Router>
        <Routes>
             <Route exact path ="/login" element= {!token ? <Login />: <Navigate to="/Dashboard" />} />
       </Routes>

       {
token ?
      <SideBar 
          onCollapse={(inactive) => {
            // console.log(inactive);
            setInactive(inactive);
          }}
        />: <></>
}
         <div className={`container ${inactive ? "inactive" : ""}`}>     
    <Routes>
      <Route exact path ="/Dashboard" element= { token ? <Dashboard />: <Navigate to="/login" />} />
      <Route exact path ="/Category" element = {token ? <ListCategory />:  <Navigate to="/login" />}  />
    </Routes> 
    </div>
</Router> 
</div>
 );

}    

if(document.getElementById('app')){
    createRoot(document.getElementById('app')).render(
    <App />
    ); 

}
