//@ts-nocheck
require('./bootstrap');
import { Application } from "@hotwired/stimulus";
import { definitionsFromContext } from "@hotwired/stimulus-webpack-helpers";

window.Stimulus = Application.start();
const context = require.context("./controllers", true, /\.ts$/);
Stimulus.load(definitionsFromContext(context));