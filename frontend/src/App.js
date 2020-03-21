import React, {Component} from 'react';
import logo from './logo.svg';
import Gallery from 'react-photo-gallery';
import './App.css';

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {photos: []};
  }
  componentDidMount() {
    const request = new Request('http://localhost:8000/api/media');
    fetch(request)
        .then(response => {
          if (response.status === 200) {
            return response.json();
          } else {
            throw new Error('Something went wrong on api server!');
          }
        })
        .then(photos => {
          this.setState({photos: photos});
        });
  }

  render() {
    return <div className="App">
      <Gallery photos={this.state.photos}/>
    </div>;
  }
}

export default App;
