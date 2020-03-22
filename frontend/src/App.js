import React, {Component} from 'react';
import Gallery from 'react-photo-gallery';
import './App.css';

class App extends Component {
    constructor(props) {
        super(props);
        this.state = {photos: []};
    }
    componentDidMount() {
        const request = new Request('http://localhost:8000/api/media/subreddit/1');
        fetch(request)
            .then(response => {
                if (response.status === 200) {
                    return response.json();
                } else {
                    throw new Error('Something went wrong with the request!');
                }
            })
            .then(photos => {
                let newest =  photos.reduce(function(cur_newest, photo) {
                    if(Date(photo.created_at) > cur_newest)
                        return photo.created_at;
                }, Date(1));
                return this.setState({photos: photos});
            });
    }

    render() {
        return <div className="App">
            <Gallery photos={this.state.photos}/>
        </div>;
    }
}

export default App;
