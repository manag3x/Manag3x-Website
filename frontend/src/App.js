import React from "react";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";

import Sidebar from "./components/Sidebar/Sidebar";
import { GlobalStyle } from "./GlobalStyle";
import Overview from "./pages/Overview";
import Finance from "./pages/Finance/Finance";
import Income from "./pages/Finance/Income";
import Statement from "./pages/Finance/Statement";
import Inventory from "./pages/Inventory";
import Settings from "./pages/Settings";
import Logistics from "./pages/Logistics";


function App() {
  return (
    <Router>
        <Sidebar />
        <Switch>
          <Route path='/overview' exact component={Overview} />
          <Route path='/finance' exact component={Finance} />
          <Route path='/finance/income' exact component={Income} />
          <Route path='/finance/statement' exact component={Statement} />
          <Route path='/inventory' exact component={Inventory} />
          <Route path='/logistics' exact component={Logistics} />
          <Route path='/settings' exact component={Settings} />

        </Switch>      
        <GlobalStyle />
    </Router>
  );
}

export default App;
