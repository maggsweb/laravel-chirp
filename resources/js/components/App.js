import React, {Component} from 'react';
import axios from 'axios';

class App extends Component {

    constructor(props) {
        super(props);
        this.state = {
            body: '',
            posts: [],
        }
        // bind 'Event handlers'
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.renderPost = this.renderPost.bind(this);
    }

    getPosts() {
        axios.get('/posts')
        .then((response) =>
            this.setState({
                posts: [...response.data.posts],
            })
        );
    }

    componentWillMount() {
        this.getPosts();
    }

    componentDidMount() {
        // Ugly way::
        // this.interval = setInterval(() => this.getPosts(), 1000);
        // Pusher way
        Echo.private('new-post').listen('PostCreated', e => {
            // If the user is following the messages user..
            if(window.Laravel.user.following.includes(e.post.user_id)) {   // ** This data is set in the header..
                // ..add the message to the state.posts
                this.setState({
                    posts: [e.post, ...this.state.posts]
                });
            }
        });
    }

    componentWillUnmount() {
        // Ugly way::
        // clearInterval(this.interval);
    }

    handleSubmit(e) {
       e.preventDefault();
        axios.post('/post', {
            body: this.state.body
        })
        .then(response => {
            this.setState({
                posts: [response.data, ...this.state.posts],
                body: ''
            })
        });
        // Clear textarea
        this.setState({
            body: ''
        })
    }

    handleChange(e) {
        this.setState({
            body: e.target.value
        })
    }

    renderPost() {
        return this.state.posts.map(post =>
            <div key={post.id} className="media">
                <div className="media-left">
                    <img src={post.user.avatar} className="media-object mr-2" />
                </div>
                <div className="media-body">
                    <div className="user">
                        <a href={`/users/${post.user.username}`}>
                            <small>{post.user.username}</small>
                        </a>{' '}
                        - { post.humanDate }
                    </div>
                    <p>{post.body}</p>
                </div>
            </div>
        )
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-6">
                        <div className="card">
                            <div className="card-header">Tweet Something</div>
                            <div className="card-body">
                                <form onSubmit={this.handleSubmit}>
                                    <div className="form-group">
                                        <textarea
                                            onChange={this.handleChange}
                                            className="form-control"
                                            rows="5"
                                            maxLength="140"
                                            placeholder="Whats Up?"
                                            value={this.state.body}
                                            required
                                        />
                                    </div>
                                    <input type="submit" value="Post" className="form-control" />
                                </form>
                            </div>
                        </div>
                    </div>

                    {this.state.posts.length > 0 && (
                        <div className="col-md-6">
                            <div className="card">
                                <div className="card-header">Recent Tweets</div>
                                <div className="card-body">
                                    { this.state.loading ? 'Loading..' : this.renderPost()}
                                </div>
                            </div>
                        </div>
                    )}

                </div>
            </div>
        );
    }
}

export default App;
