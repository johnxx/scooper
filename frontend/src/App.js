import React, {Component} from 'react';
import Gallery from 'react-photo-gallery';
import './App.css';

class App extends Component {
    constructor(props) {
        super(props);
        this.state = {photos: []};
    }

    async pollForImages(newest) {
        const base_url = 'http://localhost:8000/api/media/subreddit/1?since=';
        while (true) {
            let req = new Request(base_url + newest.toISOString());
            try {
                newest = await fetch(req)
                    .then(response => {
                        if (response.status === 200) {
                            return response.json();
                        } else {
                            throw new Error('Something went wrong with the request!');
                        }
                    })
                    .then(photos => {
                        const epoch_start = new Date(0);
                        let new_newest = photos.reduce(function(cur_newest, photo) {
                            const photo_date = new Date(photo.created_at)
                            if(photo_date.getTime() > cur_newest.getTime())
                                return photo_date;
                            else
                                return cur_newest;
                        }, epoch_start);
                        this.setState({photos: [...photos, ...this.state.photos]});
                        return new_newest;
                    });
            } catch(error) {
                console.log(error);
            }
        }
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
                const epoch_start = new Date(0);
                let newest = photos.reduce(function(cur_newest, photo) {
                    const photo_date = new Date(photo.created_at)
                    if(photo_date.getTime() > cur_newest.getTime())
                        return photo_date;
                    else
                        return cur_newest;
                }, epoch_start);
                this.setState({photos: photos});
                return newest;
            })
            .then(newest => {
                return this.pollForImages(newest);
            });
    }

    render() {
        return <div className="App">
            <Gallery photos={this.state.photos}/>
        </div>;
    }
}

export default App;
